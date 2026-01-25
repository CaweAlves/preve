<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { destroy } from '@/routes/tags';
import { Tag } from '@/types/models/tag';

const open = defineModel<boolean>('open', { required: true });

const props = defineProps<{
  tag: Tag | null;
}>();

const form = useForm({});

const deleteTag = () => {
  const tag = props.tag;
  if (!tag) return;

  form.submit(destroy(tag.id), {
    onSuccess: () => {
      open.value = false;
    }
  });
};
</script>

<template>
  <AlertDialog v-model:open="open">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This will permanently delete
          the tag "{{ tag?.name }}".
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>
          Cancel
        </AlertDialogCancel>
        <AlertDialogAction @click="deleteTag" :disabled="form.processing">
          Confirm
        </AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
