<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

interface Props {
  title: string;
}

defineProps<Props>();
</script>

<template>
  <div class="flex flex-col rounded-lg-outer border bg-sidebar p-1">
    <div class="p-2 pb-3">
      <div class="flex items-center gap-1 text-foreground">
        <Plus class="size-4" />
        <p class="text-sm">{{ title }}</p>
      </div>
    </div>

    <div class="p-4 border rounded-lg bg-background">
      <slot />
    </div>
  </div>
</template>
