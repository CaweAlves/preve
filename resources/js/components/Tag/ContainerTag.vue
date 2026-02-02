<script setup lang="ts">
import { TagsIcon } from 'lucide-vue-next';

import EmptyState from '@/components/EmptyState.vue';
import { DataTable, DataTablePaginator } from '@/components/ui/data-table';
import { columns } from '@/tables/tags';
import type { ITag } from '@/types/models/tag';

import DeleteTagDialog from './DeleteTagDialog.vue';
import EditTagDialog from './EditTagDialog.vue';

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
    >
      <template #icon>
        <TagsIcon />
      </template>
    </EmptyState>

    <DataTable v-else :columns="columns" :data="tags">
      <template #pagination="{ table }">
        <DataTablePaginator :table="table" />
      </template>
    </DataTable>

    <EditTagDialog />
    <DeleteTagDialog />
  </div>
</template>
