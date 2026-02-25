<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import HorizontalCalendarStrip from '@/components/Dashboard/HorizontalCalendarStrip.vue';
import LastTransactionsTable from '@/components/Dashboard/LastTransactionsTable.vue';
import { ITransaction } from '@/types/models/transaction';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
];

interface Props {
  transactions: ITransaction[];
}

defineProps<Props>();
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="page-container">

      <!-- HEADING -->
      <Heading
        title="Dashboard"
        description="Here you can get an overview of your financial activities and manage your transactions efficiently."
        :hasActions="true"
      >
        <!-- TODO: fix issue #41 -->
        <Button type="button"> Create </Button>
      </Heading>

      <!-- CALENDAR -->
      <HorizontalCalendarStrip />

      <!-- PLACEHOLDER -->
      <div
        class="relative min-h-100 flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
      >
        <PlaceholderPattern />
      </div>

      <!-- LAST TRANSACTIONS -->
      <LastTransactionsTable :transactions />
    </div>
  </AppLayout>
</template>
