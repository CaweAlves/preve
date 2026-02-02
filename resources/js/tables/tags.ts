import { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

import TagActions from '@/components/Tag/TagActions.vue';
import { ITag } from '@/types/models/tag';

export const columns: ColumnDef<ITag>[] = [
    {
        accessorKey: 'name',
        header: 'Name',
        cell: ({ row }) => h('p', { class: 'font-medium' }, row.original.name),
    },
    {
        accessorKey: 'description',
        header: 'Description',
        cell: ({ row }) => {
            const description = row.original.description ?? '';
            const shortDescription = description.slice(0, 25) + '…';

            return h(
                'p',
                { class: 'text-sm text-muted-foreground' },
                description.length > 25 ? shortDescription : description,
            );
        },
    },
    {
        accessorKey: 'actions',
        header: () => h('div', { class: 'text-right' }, 'Actions'),
        cell: ({ row }) => {
            const tag = row.original;

            return h('div', { class: 'text-right' }, h(TagActions, { tag }));
        },
    },
];
