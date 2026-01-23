<script setup lang="ts">
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { availableColors, getColorClass } from '@/lib/category-colors';
import { availableIcons, getIconComponent } from '@/lib/category-icons';
import { cn } from '@/lib/utils';
import { Category } from '@/types/models/category';

const open = defineModel<boolean>('open', { required: true });

const props = defineProps<{
  category: Category | null;
}>();

const name = ref('');
const slug = ref('');
const description = ref('');
const selectedIcon = ref<string>(availableIcons[0]);
const selectedColor = ref<string>(availableColors[0]);

watch(
  () => props.category,
  (category) => {
    if (category) {
      name.value = category.name || '';
      slug.value = category.slug || '';
      description.value = category.description || '';
      selectedIcon.value = category.icon || availableIcons[0];
      selectedColor.value = category.color || availableColors[0];
    }
  },
  { immediate: true }
);

const editCategory = () => {
  const category = props.category;
  if (!category) return;

  router.put(
    route('categories.update', category.id),
    {
      name: name.value,
      slug: slug.value,
      description: description.value,
      icon: selectedIcon.value,
      color: selectedColor.value,
    },
    {
      onSuccess: () => {
        open.value = false;
      },
    }
  );
};
</script>

<template>
  <Dialog :open="open">
    <form>
      <DialogContent class="sm:max-w-[500px]">
        <DialogHeader>
          <DialogTitle>Edit Category</DialogTitle>
          <DialogDescription>
            Make changes to {{ category?.name }}. Click save when you're done.
          </DialogDescription>
        </DialogHeader>
        <div class="grid grid-cols-2 gap-4">
          <div class="grid gap-3">
            <Label for="name"> Name </Label>
            <Input
              id="name"
              name="name"
              placeholder="Category Name"
              v-model="name"
            />
          </div>

          <div class="grid gap-3">
            <Label for="slug"> Slug </Label>
            <Input
              id="slug"
              name="slug"
              placeholder="category-slug"
              v-model="slug"
            />
          </div>

          <div class="col-span-2 grid gap-3">
            <Label for="description"> Description </Label>
            <Input
              id="description"
              name="description"
              placeholder="This is a category for..."
              v-model="description"
            />
          </div>

          <div class="col-span-2 grid gap-3">
            <Label>Icon</Label>
            <div class="grid grid-cols-8 gap-2 justify-start">
              <label
                v-for="icon in availableIcons"
                :key="icon"
                :class="
                  cn(
                    'p-2 flex items-center justify-center rounded border border-gray-700 cursor-pointer hover:border-primary',
                    selectedIcon === icon && 'border-primary bg-primary/10'
                  )
                "
              >
                <input
                  type="radio"
                  name="icon"
                  :value="icon"
                  v-model="selectedIcon"
                  class="sr-only"
                />
                <component :is="getIconComponent(icon)" class="size-5 text-gray-500" />
              </label>
            </div>
          </div>

          <div class="col-span-2 grid gap-3">
            <Label>Color</Label>
            <div class="flex gap-2 mt-2">
              <label
                v-for="color in availableColors"
                :key="color"
                :class="
                  cn(
                    'w-12 h-6 p-1 rounded border-2 cursor-pointer',
                    selectedColor === color ? 'border-gray-100' : 'border-gray-800'
                  )
                "
              >
                <input
                  type="radio"
                  name="color"
                  :value="color"
                  v-model="selectedColor"
                  class="sr-only"
                />
                <div :class="cn('w-full h-full rounded-xs', getColorClass(color, 'bg', 500))" />
              </label>
            </div>
          </div>
        </div>
        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline" @click="open = false"> Cancel </Button>
          </DialogClose>
          <Button @click="editCategory" type="submit"> Save changes </Button>
        </DialogFooter>
      </DialogContent>
    </form>
  </Dialog>
</template>
