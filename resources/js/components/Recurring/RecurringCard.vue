<script setup lang="ts">
import { ChartLine } from 'lucide-vue-next';
import { type Component } from 'vue';

import { Card } from '@/components/ui/card';

interface Props {
  title: string;
  description: string;
  icon?: Component;
}

withDefaults(defineProps<Props>(), {
  icon: ChartLine,
});
</script>

<template>
  <Card class="gap-2 bg-sidebar p-4">
    <div class="flex items-center gap-2 text-muted-foreground">
      <component :is="icon" class="size-5" />
      <p class="text-sm">
        {{ description }}
      </p>
    </div>
    <h2 class="text-lg font-medium">
      {{ title }}
    </h2>
  </Card>
</template>
