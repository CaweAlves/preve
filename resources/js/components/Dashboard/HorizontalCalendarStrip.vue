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
import { ref, nextTick } from 'vue';

const now = new Date();
const currentYear = now.getFullYear();
const currentMonth = now.getMonth();

const selectedYear = ref<string>(String(currentYear));
const selectedMonth = ref<number>(currentMonth);
const stripRef = ref<HTMLUListElement | null>(null);

const scrollToSelected = () => {
  nextTick(() => {
    if (!stripRef.value) return;
    const card = stripRef.value.children[selectedMonth.value] as HTMLElement;
    if (!card) return;
    card.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
  });
};

const navigate = (direction: 'prev' | 'next') => {
  if (direction === 'prev') {
    if (selectedMonth.value === 0) {
      selectedMonth.value = 11;
      selectedYear.value = String(Number(selectedYear.value) - 1);
    } else {
      selectedMonth.value--;
    }
  } else {
    if (selectedMonth.value === 11) {
      selectedMonth.value = 0;
      selectedYear.value = String(Number(selectedYear.value) + 1);
    } else {
      selectedMonth.value++;
    }
  }

  scrollToSelected();
};

const handleToCurrentMonth = () => {
  selectedYear.value = String(currentYear);
  selectedMonth.value = currentMonth;
  scrollToSelected();
}
</script>

<template>
  <section class="mb-4 p-1 border rounded-lg-outer">
    <div class="flex justify-between items-center gap-2 relative w-full overflow-auto border rounded-lg p-2 px-4">

      <!-- YEAR -->
      <Select v-model="selectedYear">
        <SelectTrigger class="w-[100px]">
          <SelectValue :placeholder="String(currentYear)" />
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
      <div class="dark:border-sidebar-border rounded-lg p-2 flex items-center gap-0 overflow-x-auto w-full h-20">
        <Button variant="ghost" type="button" class="hover:bg-muted-foreground/10" @click="navigate('prev')">
          <ChevronLeft />
        </Button>

        <ul ref="stripRef" class="w-full h-full py-1 flex items-center gap-0 overflow-hidden scroll-smooth">
          <CardCalendar
            v-for="(month, index) in MONTHS"
            :key="index"
            :month="month"
            :year="Number(selectedYear)"
            :isCurrent="index === selectedMonth"
            @select="selectedMonth = index"
          />
        </ul>

        <Button variant="ghost" type="button" class="hover:bg-muted-foreground/10" @click="navigate('next')">
          <ChevronRight />
        </Button>
      </div>

      <!-- BUTTON -->
      <Button variant="outline" type="button" @click="handleToCurrentMonth"> Today </Button>
    </div>
  </section>
</template>
