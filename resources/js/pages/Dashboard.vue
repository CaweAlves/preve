<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import HorizontalCalendarStrip from '@/components/Dashboard/HorizontalCalendarStrip.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
];
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
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div
          class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <PlaceholderPattern />
        </div>
        <div
          class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <PlaceholderPattern />
        </div>
        <div
          class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <PlaceholderPattern />
        </div>
      </div>
      <div
        class="relative min-h-full flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
      >
        <PlaceholderPattern />
      </div>
    </div>
  </AppLayout>
</template>
