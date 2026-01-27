<script setup lang="ts">
import { ref } from 'vue';

import ActionGroup from '@/components/ActionGroup.vue';
import DeleteTagDialog from '@/components/Tag/DeleteTagDialog.vue';
import EditTagDialog from '@/components/Tag/EditTagDialog.vue';
import DeleteButton from '@/components/ui/button/DeleteButton.vue';
import EditButton from '@/components/ui/button/EditButton.vue';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import { ITag } from '@/types/models/tag';

const showDeleteDialog = ref(false);
const showEditDialog = ref(false);
const selectedTag = ref<ITag | null>(null);

const openEditDialog = (tag: ITag) => {
  selectedTag.value = tag;
  showEditDialog.value = true;
};

const openDeleteDialog = (tag: ITag) => {
  selectedTag.value = tag;
  showDeleteDialog.value = true;
};

defineProps<{
  tags: ITag[];
}>();
</script>

<template>
  <Table>
    <TableCaption>Your Tags Income</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead>Name</TableHead>
        <TableHead>Description</TableHead>
        <TableHead class="text-right">Actions</TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="tag in tags" :key="tag.id">
        <TableCell class="flex items-center gap-3">
          <p class="font-medium">
            {{ tag.name }}
          </p>
        </TableCell>
        <TableCell>
          <p class="text-sm text-muted-foreground">
            {{
              tag.description && tag.description.length > 25
                ? tag.description.slice(0, 25) + '...'
                : tag.description
            }}
          </p>
        </TableCell>
        <TableCell class="text-right">
          <ActionGroup>
            <EditButton @click="openEditDialog(tag)" />

            <DeleteButton @click="openDeleteDialog(tag)" />
          </ActionGroup>
        </TableCell>
      </TableRow>
    </TableBody>

    <EditTagDialog
      v-if="showEditDialog && selectedTag"
      v-model:open="showEditDialog"
      :tag="selectedTag"
    />

    <DeleteTagDialog v-model:open="showDeleteDialog" :tag="selectedTag" />
  </Table>
</template>
