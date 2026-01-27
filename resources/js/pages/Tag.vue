<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import CreateTag from '@/components/Tag/CreateTag.vue';
import TableTag from '@/components/Tag/TableTag.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import tagRoutes from '@/routes/tags';
import { type BreadcrumbItem } from '@/types';
import type { ITag } from '@/types/models/tag';

defineProps<{
  tags: ITag[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
  {
    title: 'Tag',
    href: tagRoutes.index().url,
  },
];
</script>

<template>
  <Head title="Tag" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div
      class="mx-auto flex h-full w-full max-w-[1500px] flex-1 flex-col gap-2 overflow-x-auto rounded-xl p-4"
    >
      <!-- HEADING -->
      <Heading title="Tag" description="Manage your tags here." />

      <!-- CREATE -->
      <CreateTag />

      <!-- TABLE - CRUD -->
      <TableTag :tags />

      <!-- PLACEHOLDER -->
      <div
        class="relative min-h-full flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
      >
        <PlaceholderPattern />
      </div>
    </div>
  </AppLayout>
</template>
