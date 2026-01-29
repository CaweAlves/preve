<script setup lang="ts">
import { computed, ref } from 'vue';

import ActionGroup from '@/components/ActionGroup.vue';
import DeleteRecurringDialog from '@/components/Recurring/DeleteRecurringDialog.vue';
import EditRecurringDialog from '@/components/Recurring/EditRecurringDialog.vue';
import DeleteButton from '@/components/ui/button/DeleteButton.vue';
import EditButton from '@/components/ui/button/EditButton.vue';
import { Card } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { getIconComponent } from '@/lib/category-icons';
import { formatCentsToDisplay } from '@/lib/currency';
import { capitalizeFirstLetter, cn } from '@/lib/utils';
import { type ICategory } from '@/types/models/category';
import { IRecurringTransaction } from '@/types/models/recurring-transaction';
import { type ITag } from '@/types/models/tag';

const props = defineProps<{
  recurringTransaction: IRecurringTransaction;
  categories: ICategory[];
  tags: ITag[];
}>();

const formattedAmount = computed(() =>
  formatCentsToDisplay(props.recurringTransaction.amount),
);

const categoryIcon = computed(() =>
  getIconComponent(props.recurringTransaction.category?.icon ?? null),
);

const amountClass = computed(() =>
  cn(
    'text-sm font-medium',
    props.recurringTransaction.type === 'expense'
      ? "text-foreground before:content-['-']"
      : 'text-positive',
  ),
);

const showDeleteDialog = ref(false);
const showEditDialog = ref(false);
const selectedRecurring = ref<IRecurringTransaction | null>(null);

const openEditDialog = (recurringTransaction: IRecurringTransaction) => {
  selectedRecurring.value = recurringTransaction;
  showEditDialog.value = true;
};

const openDeleteDialog = (recurringTransaction: IRecurringTransaction) => {
  selectedRecurring.value = recurringTransaction;
  showDeleteDialog.value = true;
};
</script>

<template>
  <Card
    class="flex flex-row items-center justify-between gap-2 rounded-md bg-sidebar p-4"
  >
    <div class="flex items-center gap-4">
      <div class="space-y-1">
        <Label
          for="transaction"
          class="text-sm leading-none font-medium text-foreground"
        >
          {{ recurringTransaction.description }}
        </Label>
        <span
          class="flex items-center gap-1 text-xs leading-none font-medium text-muted-foreground"
        >
          <component :is="categoryIcon" :size="14" />
          {{ recurringTransaction.category?.name }} •
          {{ capitalizeFirstLetter(recurringTransaction.type) }}
        </span>
      </div>
    </div>

    <div>
      <span :class="amountClass"> R$ {{ formattedAmount }} </span>
      <ActionGroup>
        <EditButton @click="openEditDialog(recurringTransaction)" />

        <DeleteButton @click="openDeleteDialog(recurringTransaction)" />
      </ActionGroup>
    </div>
  </Card>

  <EditRecurringDialog
    v-if="showEditDialog && selectedRecurring"
    v-model:open="showEditDialog"
    :recurringTransaction="selectedRecurring"
    :categories="categories"
    :tags="tags"
  />

  <DeleteRecurringDialog
    v-if="showDeleteDialog && selectedRecurring"
    v-model:open="showDeleteDialog"
    :recurringTransaction="selectedRecurring"
  />
</template>
