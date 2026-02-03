<script setup lang="ts">
import { TagsIcon } from 'lucide-vue-next';

import EmptyState from '@/components/EmptyState.vue';
import { DataTable, DataTablePaginator } from '@/components/ui/data-table';
import { columns } from '@/tables/tags';
import type { IPaginate } from '@/types/models/paginated';
import type { ITag } from '@/types/models/tag';

import DeleteTagDialog from './DeleteTagDialog.vue';
import EditTagDialog from './EditTagDialog.vue';

interface Props {
  tags: IPaginate<ITag>;
}

defineProps<Props>()
</script>

<template>
  <div class="mt-4">
    <EmptyState
      v-if="tags.data.length === 0 && tags.current_page === 1"
      title="No tags yet"
      description="Start by creating your first tag"
      :showButton="false"
    >
      <template #icon>
        <TagsIcon />
      </template>
    </EmptyState>

    <DataTable v-else :columns="columns" :data="tags.data">
      <template #pagination>
        <DataTablePaginator :pagination="tags" />
      </template>
    </DataTable>

    <EditTagDialog />
    <DeleteTagDialog />
  </div>
</template>
