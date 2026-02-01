import { ColumnDef } from "@tanstack/vue-table";
import { h } from "vue";

import ActionGroup from "@/components/ActionGroup.vue";
import { ITag } from "@/types/models/tag";

export const columns: ColumnDef<ITag>[] = [
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'description',
        header: 'Description',
    },
    {
        accessorKey: 'actions',
        header: () => h('div', { class: 'text-right' }, 'Actions'), 
        cell: ({ row }) => {
            const tag = row.original;

            return h('div', { class: 'text-right' }, h(ActionGroup, tag))
        }
    },
]