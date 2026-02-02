<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import QuickCreateCard from '@/components/QuickCreateCard.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { store } from '@/routes/tags';

const form = useForm({
  name: '',
  description: '',
});

const createTag = () => {
  form.submit(store(), {
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <QuickCreateCard title="New Tag">
    <form class="flex w-full flex-wrap items-start gap-3" @submit.prevent="createTag">
        <div class="flex flex-col gap-2 justify-start min-w-1/4">
          <Label for="name">Name</Label>
          <Input
            id="name"
            name="name"
            placeholder="Name"
            v-model="form.name"
          />
          <InputError :message="form.errors.name" />
        </div>
  
        <div class="flex flex-col gap-2 flex-1 justify-start min-w-1/4">
          <Label for="description">Description</Label>
          <Input
            id="description"
            name="description"
            placeholder="Describe your tag"
            v-model="form.description"
          />
          <InputError :message="form.errors.description" />
        </div>
  
        <div class="h-full flex items-start pt-5.5">
          <Button type="submit" :disabled="form.processing" class="h-9">
            Create
          </Button>
        </div>
      </form>
  </QuickCreateCard>
</template>
