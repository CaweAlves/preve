<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { update } from '@/routes/tags';
import { useTagStore } from '@/stores/tag.store';

const tagStore = useTagStore();

const form = useForm({
  name: '',
  description: '',
});

watch(
  () => tagStore.tag,
  (newTag) => {
    if (newTag) {
      form.name = newTag.name;
      form.description = newTag.description ?? '';
      form.clearErrors();
    } else {
      form.reset();
    }
  },
);

function handleUpdateTag() {
  if (!tagStore.tag) return;

  form.submit(update(tagStore.tag.id), {
    onSuccess: () => {
      tagStore.closeEditModal();
    },
  });
}

function handleOpenUpdate(open: boolean) {
  if (!open) {
    tagStore.closeEditModal();
  }
}
</script>

<template>
  <Dialog
    v-model:open="tagStore.showEditDialog"
    @update:open="handleOpenUpdate"
  >
    <form>
      <DialogContent class="sm:max-w-[500px]">
        <DialogHeader>
          <DialogTitle>Edit Tag</DialogTitle>
          <DialogDescription>
            Make changes to {{ tagStore.tag?.name }}. Click save when you're
            done.
          </DialogDescription>
        </DialogHeader>

        <div class="grid gap-4">
          <div class="grid gap-3">
            <Label for="name">Name</Label>
            <Input
              id="name"
              name="name"
              placeholder="Tag Name"
              v-model="form.name"
            />
            <InputError :message="form.errors.name" />
          </div>

          <div class="grid gap-3">
            <Label for="description">Description</Label>
            <Input
              id="description"
              name="description"
              placeholder="This is a tag for..."
              v-model="form.description"
            />
            <InputError :message="form.errors.description" />
          </div>
        </div>

        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline">Cancel</Button>
          </DialogClose>
          <Button @click="handleUpdateTag" :disabled="form.processing">
            Save changes
          </Button>
        </DialogFooter>
      </DialogContent>
    </form>
  </Dialog>
</template>
