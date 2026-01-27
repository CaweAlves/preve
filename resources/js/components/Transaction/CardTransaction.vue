<script setup lang="ts">
import { ref } from 'vue';

import ActionGroup from '@/components/ActionGroup.vue';
import DeleteTransactionDialog from '@/components/Transaction/DeleteTransactionDialog.vue';
import EditTransactionDialog from '@/components/Transaction/EditTransactionDialog.vue';
import DeleteButton from '@/components/ui/button/DeleteButton.vue';
import EditButton from '@/components/ui/button/EditButton.vue';
import { Card } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import { ITransaction } from '@/types/models/transaction';

defineProps<{
  transaction: ITransaction;
}>();

const showDeleteDialog = ref(false);
const showEditDialog = ref(false);
const selectedTransaction = ref<ITransaction | null>(null);

const openEditDialog = (transaction: ITransaction) => {
  selectedTransaction.value = transaction;
  showEditDialog.value = true;
};

const openDeleteDialog = (transaction: ITransaction) => {
  selectedTransaction.value = transaction;
  showDeleteDialog.value = true;
};
</script>

<template>
  <Card
    class="flex flex-row items-center justify-between gap-2 rounded-md bg-sidebar p-4"
  >
    <div class="flex items-center gap-4">
      <Checkbox id="transaction" class="size-5" />
      <div class="space-y-0">
        <Label
          for="transaction"
          class="text-sm leading-none font-medium text-foreground"
        >
          {{ transaction.description }}
        </Label>
        <span class="text-xs leading-none font-medium text-muted-foreground">
          {{ transaction.category?.name }} • {{ transaction.type }}
        </span>
      </div>
    </div>

    <div>
      <span :class="cn('text-sm font-medium text-muted-foreground', transaction.type === 'expense' ? 'text-destructive' : 'text-positive')">
        {{ transaction.amount }}
      </span>
      <ActionGroup>
        <EditButton @click="openEditDialog(transaction)" />

        <DeleteButton @click="openDeleteDialog(transaction)" />
      </ActionGroup>
    </div>
  </Card>

  <EditTransactionDialog
    v-if="showEditDialog && selectedTransaction"
    v-model:open="showEditDialog"
    :transaction="selectedTransaction"
  />

  <DeleteTransactionDialog
    v-if="showDeleteDialog && selectedTransaction"
    v-model:open="showDeleteDialog"
    :transaction="selectedTransaction"
  />
</template>
