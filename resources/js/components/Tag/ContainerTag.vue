<script setup lang="ts">
import EmptyState from '@/components/EmptyState.vue';
import { DataTable, DataTablePaginator } from '@/components/ui/data-table';
import { columns } from '@/tables/tags';
import type { ITag } from '@/types/models/tag';

defineProps<{
  tags: ITag[];
}>();
</script>

<template>
  <div class="mt-4">
    <EmptyState
      v-if="tags.length === 0"
      title="No tags yet"
      description="Start by creating your first tag"
      :showButton="false"
    />

    <DataTable v-else :columns="columns" :data="tags">
      <template #pagination="{ table }">
        <DataTablePaginator :table="table" />
      </template>
    </DataTable>
  </div>
</template>
