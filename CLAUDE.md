# Preve - Project Context for AI

This file helps AI assistants understand the Preve project structure, patterns, and conventions.

## Project Overview

**Preve** is a personal finance management application built with:
- **Backend**: Laravel 12 + Inertia.js
- **Frontend**: Vue 3 + TypeScript + Tailwind CSS
- **UI Components**: shadcn/ui pattern
- **Database**: MySQL (with user-scoped data)

## Core Entities

1. **User** - Authentication and ownership
2. **Category** - Transaction categories (with color and icon)
3. **Tag** - Optional transaction tags
4. **Transaction** - Income/Expense records

All entities are **user-scoped** (multi-tenant at user level).

---

## Backend Patterns

### File Structure
```
app/
├── Enums/TransactionType.php
├── Http/Controllers/{Entity}Controller.php
├── Http/Requests/Create{Entity}Request.php
├── Models/{Entity}.php
└── Policies/{Entity}Policy.php
```

### Form Requests Pattern
```php
class CreateCategoryRequest extends FormRequest
{
    use GeneratesUniqueSlug; // Trait for shared logic

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:...'],
        ];
    }

    protected function getModelClass(): string
    {
        return Category::class;
    }
}
```

**Key Points:**
- ✅ Use traits in `/Concerns/` for shared logic (e.g., slug generation)
- ✅ Slugs are auto-generated in `prepareForValidation()`
- ✅ User-scoped uniqueness checks

### Controller Pattern
```php
class TransactionController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $transactions = Auth::user()->transactions()->get();
        $categories = Auth::user()->categories()->get();

        return Inertia::render('Transaction', compact('transactions', 'categories'));
    }

    public function store(CreateTransactionRequest $request)
    {
        Auth::user()->transactions()->create($request->validated());
        return to_route('transactions.index');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        $transaction->update($request->all());
        return to_route('transactions.index');
    }
}
```

**Key Points:**
- ✅ Use `Inertia::render()` for views
- ✅ Use `compact()` for passing data
- ✅ Use `Auth::user()->relationships()` for user-scoped queries
- ✅ Use `$this->authorize()` with policies
- ✅ Use `to_route()` for redirects

### Model Pattern
```php
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'amount', 'type', ...];

    protected $casts = [
        'transaction_date' => 'datetime',
        'type' => TransactionType::class,
    ];

    public function user(): BelongsTo { ... }
    public function category(): BelongsTo { ... }
}
```

### Enum Pattern
```php
enum TransactionType: string
{
    case INCOME = 'income';
    case EXPENSE = 'expense';

    public function label(): string
    {
        return match ($this) {
            self::INCOME => 'Income',
            self::EXPENSE => 'Expense',
        };
    }
}
```

---

## Frontend Patterns

### File Structure
```
resources/js/
├── components/
│   ├── ui/                          # shadcn/ui components
│   │   ├── button/, dialog/, input/, select/, toggle-group/
│   ├── Category/                    # Entity components
│   │   ├── CreateCategory.vue
│   │   ├── EditCategoryDialog.vue
│   │   ├── DeleteCategoryDialog.vue
│   │   └── TableCategory.vue
│   └── Transaction/
├── enums/transaction-type.ts        # Frontend constants
├── lib/
│   ├── currency.ts                  # Utility functions
│   ├── category-colors.ts
│   └── category-icons.ts
├── pages/Category.vue               # Inertia pages
├── routes/categories.ts             # Route helpers
└── types/models/category.d.ts       # TypeScript types
```

### Type Definitions Pattern

**IMPORTANT:** All model interfaces use `I` prefix:

```typescript
// types/models/transaction.d.ts
export type TransactionType = 'income' | 'expense';

export interface ITransaction {
    id?: string;
    category_id: number;
    category?: ICategory;       // Relationship
    tag_id: number | null;      // Optional foreign key
    tag?: ITag | null;          // Optional relationship
    amount: number;             // In cents (integer)
    type: TransactionType;
    description: string;
    notes: string | null;       // Optional field
    transaction_date: string;
    created_at?: string;
    updated_at?: string;
}
```

### Constants Pattern (NOT TypeScript Enums)

```typescript
// enums/transaction-type.ts
import type { TransactionType } from '@/types/models/transaction';

export const TRANSACTION_TYPE = {
    INCOME: 'income' as TransactionType,
    EXPENSE: 'expense' as TransactionType,
};
```

**Why not TypeScript enums?**
- Better Inertia.js compatibility
- Predictable JSON serialization
- No runtime overhead

### Form Pattern (ALWAYS use useForm)

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { store } from '@/routes/transactions';
import type { ITransaction } from '@/types/models/transaction';

const open = defineModel<boolean>('open', { required: true });

defineProps<{
  categories: ICategory[];
}>();

const form = useForm<ITransaction>({
  category_id: 0,
  tag_id: null,           // Optional = null
  amount: 0,
  type: TRANSACTION_TYPE.EXPENSE,
  description: '',
  notes: null,            // Optional = null
  transaction_date: new Date().toISOString().split('T')[0],
});

const createTransaction = () => {
  form.submit(store(), {
    onSuccess: () => {
      open.value = false;
      form.reset();
    },
  });
};
</script>

<template>
  <form @submit.prevent="createTransaction">
    <Input v-model="form.name" />
    <InputError :message="form.errors.name" />

    <Button type="submit" :disabled="form.processing">
      Create
    </Button>
  </form>
</template>
```

**Key Points:**
- ✅ ALWAYS use `useForm()` composable (never `<Form>` component or `router.*`)
- ✅ Show errors with `<InputError :message="form.errors.field" />`
- ✅ Disable buttons with `:disabled="form.processing"`
- ✅ Use `null` for optional fields (not `0` or `''`)
- ✅ Use `form.submit(route(), { onSuccess, onError })`

### Component Structure Pattern

```vue
<script setup lang="ts">
// 1. Imports (grouped)
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// UI Components
import { Button } from '@/components/ui/button';

// Utils
import { formatCentsToDisplay } from '@/lib/currency';

// Types
import type { ICategory } from '@/types/models/category';

// 2. Props/Model
const open = defineModel<boolean>('open', { required: true });

defineProps<{
  categories: ICategory[];
}>();

// 3. State
const form = useForm({ ... });

// 4. Computed
const displayAmount = computed(() => ...);

// 5. Methods
const handleSubmit = () => { ... };
</script>

<template>
  <!-- Template -->
</template>

<style scoped>
/* Only if necessary */
</style>
```

### Utility Functions Pattern

```typescript
// lib/currency.ts

/**
 * Formats a value in cents to Brazilian currency display format
 * @param cents - Value in cents (e.g., 12510 = R$ 125.10)
 * @returns Formatted string (e.g., "125,10")
 */
export function formatCentsToDisplay(cents: number | string): string {
  const numericCents = typeof cents === 'string' ? parseInt(cents, 10) : cents;
  if (isNaN(numericCents) || numericCents === 0) return '0,00';
  return (numericCents / 100).toFixed(2).replace('.', ',');
}
```

**Key Points:**
- ✅ Pure functions (no side effects)
- ✅ Include examples in comments
- ✅ Place in `/lib/` folder

---

## Important Conventions

### Naming

**Backend:**
- Classes: `{Entity}Controller`, `Create{Entity}Request`, `{Entity}Policy`
- Methods: RESTful (index, store, show, update, destroy)
- Variables: `$user`, `$validated`, `$transactions`

**Frontend:**
- Files: PascalCase for components, kebab-case for utilities
- Interfaces: `I` prefix (IUser, ICategory, ITransaction)
- Constants: UPPERCASE (`TRANSACTION_TYPE`)
- Functions: camelCase (`formatCentsToDisplay`)

### Data Flow

1. **Backend** returns full objects: `$categories = Auth::user()->categories()->get()`
2. **Inertia** passes to frontend: `Inertia::render('Page', compact('categories'))`
3. **Frontend** receives typed props: `defineProps<{ categories: ICategory[] }>()`
4. **Form** submits with `form.submit(route())`
5. **Backend** validates with FormRequest, saves, redirects

### Money/Currency Handling

- **Backend**: Stores amount in **cents (integer)** in database
- **Frontend**:
  - Displays formatted: `formatCentsToDisplay(12510)` → `"125,10"`
  - Sends as integer cents: `parseToCents("12510")` → `12510`
  - Uses currency mask input

### Special UI Patterns

**Currency Input with Mask:**
```vue
<Input
  v-model="displayAmount"
  inputmode="numeric"
  @keypress="(e) => { if (!/[0-9]/.test(e.key)) e.preventDefault(); }"
  class="text-right font-mono"
/>
```

**Date Input with Visible Icon:**
```vue
<Input
  type="date"
  v-model="form.transaction_date"
  class="[&::-webkit-calendar-picker-indicator]:invert [&::-webkit-calendar-picker-indicator]:dark:invert-0"
/>
```

**Toggle Group for Type:**
```vue
<ToggleGroup v-model="form.type">
  <ToggleGroupItem :value="TRANSACTION_TYPE.INCOME" class="flex-1 gap-2">
    <ArrowUpRight :size="16" />
    Income
  </ToggleGroupItem>
  <ToggleGroupItem :value="TRANSACTION_TYPE.EXPENSE" class="flex-1 gap-2">
    <ArrowDownLeft :size="16" />
    Expense
  </ToggleGroupItem>
</ToggleGroup>
```

---

## Critical Rules

### ✅ ALWAYS DO

**Backend:**
- Use Form Requests for validation
- Extract shared logic to traits in `/Concerns/`
- Use `Inertia::render()` for views
- Use policies for authorization (`$this->authorize()`)
- Use `compact()` for passing data
- Use `Auth::user()` for current user
- Use `to_route()` for redirects

**Frontend:**
- Use `useForm()` composable for ALL forms
- Use interfaces with `I` prefix (IUser, ICategory, ITransaction)
- Show validation errors: `<InputError :message="form.errors.field" />`
- Disable buttons during submit: `:disabled="form.processing"`
- Use `null` for optional fields (not `''` or `0`)
- Extract utilities to `/lib/` folder
- Document utility functions with JSDoc (English)
- Use `import type` for type-only imports

### ❌ NEVER DO

**Backend:**
- Don't validate in controllers (use Form Requests)
- Don't use `auth()->user()` (use `Auth::user()`)
- Don't return views directly (use Inertia)
- Don't check authorization manually (use policies)

**Frontend:**
- Don't use `<Form>` component (use `useForm()`)
- Don't use `router.post/put/delete` (use `form.submit()`)
- Don't use TypeScript enums (use const objects)
- Don't use empty strings for optional fields (use `null`)
- Don't forget `form.errors` and `form.processing`
- Don't put complex logic in templates (use computed/methods)

---

## Quick Reference

### Creating a New Entity

1. **Backend:**
   - Create migration
   - Create model with relationships
   - Create FormRequest (use trait if needs slug)
   - Create controller (use Inertia)
   - Create policy if needed
   - Add routes

2. **Frontend:**
   - Create type in `/types/models/{entity}.d.ts` (use `I` prefix)
   - Create components folder: `/components/{Entity}/`
   - Create page in `/pages/{Entity}.vue`
   - Create route helpers (Ziggy)
   - Add entity-specific utilities if needed

### Common File Locations

- **Form validation**: `app/Http/Requests/`
- **Shared request logic**: `app/Http/Requests/Concerns/`
- **Type definitions**: `resources/js/types/models/`
- **Utility functions**: `resources/js/lib/`
- **UI components**: `resources/js/components/ui/`
- **Entity components**: `resources/js/components/{Entity}/`
- **Pages**: `resources/js/pages/`

---

**Last Updated**: 2026-01-25
**Laravel Version**: 11
**Vue Version**: 3
**TypeScript**: Strict mode
