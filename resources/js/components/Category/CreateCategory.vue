<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
</script>

<template>
  <div class="flex flex-col gap-4 rounded bg-sidebar p-4">
    <div class="flex items-center gap-1">
      <Plus :size="18" class="text-muted-foreground" />
      <p class="text-sm text-muted-foreground">New Category</p>
    </div>

    <form class="flex items-center gap-2">
      <div class="grid gap-1">
        <Label for="name"> Name </Label>
        <Input id="name" name="name" placeholder="Category Name" />
      </div>

      <div class="grid gap-1">
        <Label for="slug"> Slug </Label>
        <Input id="slug" name="slug" placeholder="category-slug" />
      </div>

      <Button type="submit"> Create </Button>
    </form>
  </div>
</template>

<style scoped></style>
