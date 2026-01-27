<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

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
import { ITag } from '@/types/models/tag';

const open = defineModel<boolean>('open', { required: true });

const props = defineProps<{
  tag: ITag;
}>();

const form = useForm({
  name: props.tag.name,
  slug: props.tag.slug,
  description: props.tag.description ?? '',
});

const updateTag = () => {
  form.submit(update(props.tag.id), {
    onSuccess: () => {
      open.value = false;
    },
  });
};
</script>

<template>
  <Dialog v-model:open="open">
    <form>
      <DialogContent class="sm:max-w-[500px]">
        <DialogHeader>
          <DialogTitle>Edit Tag</DialogTitle>
          <DialogDescription>
            Make changes to {{ tag?.name }}. Click save when you're done.
          </DialogDescription>
        </DialogHeader>

        <div class="grid grid-cols-2 gap-4">
          <div class="grid gap-3">
            <Label for="name"> Name </Label>
            <Input
              id="name"
              name="name"
              placeholder="Tag Name"
              v-model="form.name"
            />
            <InputError :message="form.errors.name" />
          </div>

          <div class="grid gap-3">
            <Label for="slug"> Slug </Label>
            <Input
              id="slug"
              name="slug"
              placeholder="tag-slug"
              v-model="form.slug"
            />
            <InputError :message="form.errors.slug" />
          </div>

          <div class="col-span-2 grid gap-3">
            <Label for="description"> Description </Label>
            <Input
              id="description"
              name="description"
              placeholder="This is a category for..."
              v-model="form.description"
            />
            <InputError :message="form.errors.description" />
          </div>
        </div>

        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline"> Cancel </Button>
          </DialogClose>
          <Button type="button" @click="updateTag" :disabled="form.processing">
            Save changes
          </Button>
        </DialogFooter>
      </DialogContent>
    </form>
  </Dialog>
</template>
