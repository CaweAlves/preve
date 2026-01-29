<script setup lang="ts">
import CardRecurring from '@/components/Recurring/CardRecurring.vue';
import { type ICategory } from '@/types/models/category';
import { IRecurringTransaction } from '@/types/models/recurring-transaction';
import { type ITag } from '@/types/models/tag';

defineProps<{
  recurringTransactions: IRecurringTransaction[];
  categories: ICategory[];
  tags: ITag[];
}>();
</script>

<template>
  <div class="space-y-2">
    <CardRecurring
      :recurringTransaction="recurringTransaction"
      :categories="categories"
      :tags="tags"
      v-for="recurringTransaction in recurringTransactions"
      :key="recurringTransaction.id"
    />
  </div>
</template>
