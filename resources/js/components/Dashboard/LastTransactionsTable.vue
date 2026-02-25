<script setup lang="ts">

import { Table, TableBody, TableCell, TableFooter, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Link } from '@inertiajs/vue3';
import { ITransaction } from '@/types/models/transaction';
import { cn } from '@/lib/utils';
import { formatCentsToDisplay } from '@/lib/currency';
import { Button } from '@/components/ui/button';
import { getIconComponent } from '@/lib/category-icons';
import transactions from '@/routes/transactions';
import { formatTransactionDate } from '@/utils/formatDate';

interface Props {
  latestTransactions: ITransaction[];
}

defineProps<Props>();

function getAmountClass(type: string) {
  return cn(
    'text-sm font-medium',
    type === 'expense'
      ? "text-foreground/70 before:content-['-']"
      : 'text-positive',
  );
}
</script>

<template>
  <Table>
    <TableHeader>
      <TableRow>
        <TableHead>Last Transactions</TableHead>
        <TableHead class="text-right">Amount</TableHead>
      </TableRow>
    </TableHeader>

    <TableBody>
      <TableRow v-for="transaction in latestTransactions" :key="transaction.id">
        <TableCell class="space-y-1">
          <p class="text-sm text-muted-foreground">
            {{ transaction.description }}
          </p>

          <div class="flex items-center gap-1 text-xs leading-none font-medium text-muted-foreground">
            <component :is="getIconComponent(transaction.category?.icon ?? null)" :size="14" />
            {{ transaction.category?.name }}
            •
            <span class="ml-1">
              {{ formatTransactionDate(transaction.transaction_date) }}
            </span>
          </div>
        </TableCell>

        <TableCell class="text-right">
          <p :class="getAmountClass(transaction.type)">
            R$ {{ formatCentsToDisplay(transaction.amount) }}
          </p>
        </TableCell>
      </TableRow>
    </TableBody>

    <TableFooter>
      <TableRow>
        <TableCell :colspan="2" class="py-0">
          <Link :href="transactions.index.url()">
            <Button variant="ghost" size="sm" class="w-full text-muted-foreground hover:bg-transparent hover:underline">
              View All
            </Button>
          </Link>
        </TableCell>
      </TableRow>
    </TableFooter>
  </Table>
</template>
