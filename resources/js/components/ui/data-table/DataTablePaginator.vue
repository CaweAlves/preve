<script setup lang="ts" generic="TData">
import Button from '@/components/ui/button/Button.vue';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { type IPaginate } from '@/types/models/paginated';
import { router } from '@inertiajs/vue3';

import { ChevronLeftIcon, ChevronRightIcon, ChevronsLeftIcon, ChevronsRightIcon } from 'lucide-vue-next';
import { AcceptableValue } from 'reka-ui';
import { computed } from 'vue';

const props = defineProps<{
  pagination: IPaginate<TData>
}>()

const currentPage = computed(() => props.pagination.current_page)
const totalPages = computed(() => props.pagination.last_page)
const pageSize = computed(() => props.pagination.per_page)

const getQueryParams = (overrides: Record<string, any>) => {
  const params = new URLSearchParams(window.location.search)

  Object.entries(overrides).forEach(([key, value]) => {
    if (value === null || value === undefined) {
      params.delete(key);
    } else {
      params.set(key, String(value));
    }
  });

  return Object.fromEntries(params.entries())
}

const navigate = (params: Record<string, any>) => {
  router.get(window.location.pathname, getQueryParams(params), {
    preserveState: true,
    preserveScroll: true,
  })
}

function handlePageSizeChange(value: AcceptableValue) {
  navigate({
    page: 1,
    per_page: Number(value),
  })
}

function handlePageChange(page: number) {
  navigate({ page })
}
</script>

<template>
  <div class="flex items-center justify-between px-2">
    <div class="flex-1 text-sm text-muted-foreground">
      Page {{ currentPage }} of {{ totalPages }}
    </div>
    <div class="flex items-center space-x-6 lg:space-x-8">
      <div class="flex items-center space-x-2">
        <p class="text-sm font-medium">
          Rows per page
        </p>
        <Select :model-value="`${pageSize}`" @update:model-value="handlePageSizeChange">
          <SelectTrigger class="h-8 w-[70px]">
            <SelectValue :placeholder="`${pageSize}`" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem v-for="size in [10, 20, 30, 40, 50]" :key="size" :value="`${size}`">
              {{ size }}
            </SelectItem>
          </SelectContent>
        </Select>
      </div>
      <div class="flex items-center space-x-2">
        <Button
          variant="outline"
          class="hidden size-8 p-0 lg:flex"
          :disabled="currentPage === 1"
          @click="handlePageChange(1)"
        >
          <span class="sr-only">Go to first page</span>
          <ChevronsLeftIcon class="size-4" />
        </Button>
        <Button
          variant="outline"
          class="size-8 p-0"
          :disabled="!pagination.prev_page_url"
          @click="handlePageChange(currentPage - 1)"
        >
          <span class="sr-only">Go to previous page</span>
          <ChevronLeftIcon class="size-4" />
        </Button>
        <Button
          variant="outline"
          class="size-8 p-0"
          :disabled="!pagination.next_page_url"
          @click="handlePageChange(currentPage + 1)"
        >
          <span class="sr-only">Go to next page</span>
          <ChevronRightIcon class="size-4" />
        </Button>
        <Button
          variant="outline"
          class="hidden size-8 p-0 lg:flex"
          :disabled="currentPage === totalPages"
          @click="handlePageChange(totalPages)"
        >
          <span class="sr-only">Go to last page</span>
          <ChevronsRightIcon class="size-4" />
        </Button>
      </div>
    </div>
  </div>
</template>