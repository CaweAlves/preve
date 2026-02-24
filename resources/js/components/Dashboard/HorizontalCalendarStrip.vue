<script setup lang="ts">
import { ChevronRight, ChevronLeft } from 'lucide-vue-next';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Button } from '@/components/ui/button';
import CardCalendar from '@/components/Dashboard/CardCalendar.vue';
import { MONTHS } from '@/lib/calendar';

const currentMonth = new Date().getMonth();
</script>

<template>
  <section class="flex justify-between items-center gap-4 mb-4">
    <!-- YEAR -->
    <Select>
      <SelectTrigger class="w-[100px]">
        <SelectValue placeholder="2026" />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          <SelectLabel>Year</SelectLabel>
          <SelectItem value="2026">
            2026
          </SelectItem>
          <SelectItem value="2027">
            2027
          </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>

    <!-- STRIP -->
    <div class="border border-sidebar-border/70 dark:border-sidebar-border rounded-lg p-2 flex items-center gap-1 overflow-x-auto w-full h-18">
      <Button variant="ghost" type="button" class="hover:bg-muted-foreground/10">
        <ChevronLeft />
      </Button>

      <ul class="w-full flex items-center gap-0 overflow-hidden  h-full">
        <CardCalendar
          v-for="(month, index) in MONTHS"
          :key="index"
          :month="month"
          :year="2026"
          :isCurrent="index === currentMonth"
        />
      </ul>

      <Button variant="ghost" type="button" class="hover:bg-muted-foreground/10">
        <ChevronRight />
      </Button>
    </div>

    <!-- BUTTON -->
    <Button variant="outline" type="button"> Today </Button>
  </section>
</template>
