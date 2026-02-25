<script setup lang="ts">

import { Table, TableBody, TableCell, TableFooter, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ITransaction } from '@/types/models/transaction';
import { cn } from '@/lib/utils';
import { formatCentsToDisplay } from '@/lib/currency';
import { Button } from '@/components/ui/button';

interface Props {
  transactions: ITransaction[];
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
      <TableRow v-for="transaction in transactions" :key="transaction.id">
        <TableCell class="flex items-center gap-3">
          <p class="text-sm text-muted-foreground">{{ transaction.description }}</p>
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
          <Button variant="ghost" size="sm" class="w-full text-muted-foreground hover:bg-muted-foreground/10">
            View All
          </Button>
        </TableCell>
      </TableRow>
    </TableFooter>
  </Table>
</template>
