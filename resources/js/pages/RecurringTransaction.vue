<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import RecurringCards from '@/components/Recurring/RecurringCards.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Recurring',
    href: dashboard().url,
  }
];
</script>

<template>
  <Head title="Recurring" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div
      class="mx-auto flex h-full w-full max-w-[1500px] flex-1 flex-col gap-2 overflow-x-auto rounded-xl p-4"
    >
      <!-- HEADING -->
      <Heading
        title="Recurring Transactions"
        description="Manage your recurring transactions here."
        :hasActions="true"
      >
        <Button type="button"> Create </Button>
      </Heading>

      <RecurringCards />
    </div>
  </AppLayout>
</template>
