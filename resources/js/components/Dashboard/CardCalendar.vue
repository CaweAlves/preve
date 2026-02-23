<script setup lang="ts">
import { Button } from '@/components/ui/button';

interface Props {
  month: string;
  year: number;
}

defineProps<Props>();

</script>

<template>
  <Button class="flex flex-col gap-1 h-full" variant="ghost" type="button">
    <p class="pt-3 text-md font-medium text-foreground">
      {{ month }}
    </p>
    <span class="text-[10px] text-muted-foreground pb-3">
      {{ year }}
    </span>
  </Button>
</template>
