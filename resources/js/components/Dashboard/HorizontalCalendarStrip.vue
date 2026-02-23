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
    <div class="border border-sidebar-border/70 dark:border-sidebar-border rounded-lg p-2 flex items-center gap-2 overflow-x-auto w-full h-18">
      <Button variant="ghost" type="button">
        <ChevronLeft />
      </Button>

      <ul class="w-full flex items-center gap-0 overflow-hidden  h-full">
        <CardCalendar
          month="January"
          year="2026"
        />

        <CardCalendar
          month="February"
          year="2026"
        />

        <CardCalendar
          month="Mar"
          year="2026"
        />
        <CardCalendar
          month="Apr"
          year="2026"
        />
        <CardCalendar
          month="May"
          year="2026"
        />
        <CardCalendar
          month="Jun"
          year="2026"
        />
        <CardCalendar
          month="Jul"
          year="2026"
        />
        <CardCalendar
          month="Aug"
          year="2026"
        />
        <CardCalendar
          month="Sep"
          year="2026"
        />
        <CardCalendar
          month="Oct"
          year="2026"
        />
        <CardCalendar
          month="Nov"
          year="2026"
        />
        <CardCalendar
          month="Dec"
          year="2026"
        />
      </ul>

      <Button variant="ghost" type="button">
        <ChevronRight />
      </Button>
    </div>

    <!-- BUTTON -->
    <Button variant="outline" type="button"> Today </Button>
  </section>
</template>
