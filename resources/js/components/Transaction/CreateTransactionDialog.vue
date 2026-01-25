<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { TRANSACTION_TYPE } from '@/enums/transaction-type';
import { store } from '@/routes/transactions';
import { ICategory } from '@/types/models/category';
import { ITransaction } from '@/types/models/transaction';

const open = defineModel<boolean>('open', { required: true });

defineProps<{
  categories: ICategory[];
}>();

const form = useForm<ITransaction>({
  category_id: 0,
  tag_id: 0,
  amount: 0,
  type: TRANSACTION_TYPE.EXPENSE,
  description: '',
  notes: '',
  transaction_date: '',
});

const createTransaction = () => {
  form.submit(store(), {
    onSuccess: () => {
      open.value = false;
      form.reset();
    },
  });
};
</script>

<template>
  <Dialog v-model:open="open">
    <form>
      <DialogContent class="sm:max-w-[500px]">
        <DialogHeader>
          <DialogTitle>Create Transaction</DialogTitle>
          <DialogDescription>
            Fill in the details below to create a new transaction.
          </DialogDescription>
        </DialogHeader>

        <div class="grid grid-cols-2 gap-4">
          <div class="grid gap-3">
            <Label for="category"> Category </Label>
            <Select v-model="form.category_id">
              <SelectTrigger>
                <SelectValue placeholder="Select a category" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectLabel>Category</SelectLabel>
                  <SelectItem
                    v-for="category in categories"
                    :value="category.id"
                    :key="category.id"
                  >
                    {{ category.name }}
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
            <InputError :message="form.errors.category_id" />
          </div>
        </div>

        <DialogFooter>
          <DialogClose as-child>
            <Button variant="outline"> Cancel </Button>
          </DialogClose>
          <Button
            type="button"
            @click="createTransaction"
            :disabled="form.processing"
          >
            Create Transaction
          </Button>
        </DialogFooter>
      </DialogContent>
    </form>
  </Dialog>
</template>
