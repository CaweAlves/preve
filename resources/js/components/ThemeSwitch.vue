<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import { SwitchRoot, SwitchThumb } from 'reka-ui';

import { useAppearance } from '@/composables/useAppearance';

const { appearance, updateAppearance } = useAppearance();

const toggle = (checked: boolean) => {
  updateAppearance(checked ? 'dark' : 'light');
};
</script>

<template>
  <div>
    <div class="relative inline-grid h-7 grid-cols-[1fr_1fr] items-center text-sm font-medium">
      <SwitchRoot
        :checked="appearance === 'dark'"
        class="data-[state=checked]:bg-input/50 data-[state=unchecked]:bg-input/50 peer absolute inset-0 h-[inherit] w-auto cursor-pointer rounded-full [&_span]:h-full [&_span]:w-1/2 [&_span]:transition-transform [&_span]:duration-300 [&_span]:[transition-timing-function:cubic-bezier(0.16,1,0.3,1)] data-[state=checked]:[&_span]:translate-x-full rtl:data-[state=checked]:[&_span]:-translate-x-full"
        @update:modelValue="toggle"
      >
        <SwitchThumb class="pointer-events-none block rounded-full bg-background shadow-xs" />
      </SwitchRoot>
      <span
        class="peer-data-[state=checked]:text-muted-foreground/70 pointer-events-none relative ms-0.5 flex min-w-8 items-center justify-center text-center"
      >
        <Moon :size="16" :stroke-width="2" aria-hidden="true" />
      </span>
      <span
        class="peer-data-[state=unchecked]:text-muted-foreground/70 pointer-events-none relative me-0.5 flex min-w-8 items-center justify-center text-center"
      >
        <Sun :size="16" :stroke-width="2" aria-hidden="true" />
      </span>
    </div>
    <span class="sr-only">Toggle theme</span>
  </div>
</template>
