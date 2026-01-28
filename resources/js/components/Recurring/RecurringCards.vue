<script setup lang="ts">
import { ChartLine, ArrowUpRight, ArrowDownLeft } from 'lucide-vue-next';

import RecurringCard from '@/components/Recurring/RecurringCard.vue';
</script>

<template>
  <section class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
    <RecurringCard
      title="R$100,00"
      description="Recurring Income"
      :icon="ArrowDownLeft"
      color="destructive"
    />

    <RecurringCard
      title="R$100,00"
      description="This is a recurring transaction card."
      :icon="ArrowUpRight"
      color="positive"
    />

    <RecurringCard
      title="R$0,00"
      description="This is a recurring transaction card."
      :icon="ChartLine"
    />
  </section>
</template>
