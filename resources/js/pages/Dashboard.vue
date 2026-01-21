<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler,
} from 'chart.js';

import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';

// Registrar componentes do Chart.js
ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
    Filler
);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

// Meses do ano
const months = [
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
];

// Mês selecionado (Janeiro como padrão)
const selectedMonth = ref(0);

// Dados mockados de receitas e despesas
const financialData = {
    income: 5500.00,
    expenses: 3200.00,
};

const balance = computed(() => financialData.income - financialData.expenses);

// Dia atual do mês (para simular)
const currentDay = 21;

// Gerar dados para o gráfico
const generateChartData = () => {
    const daysInMonth = 30; // Simplificado
    const labels = Array.from({ length: daysInMonth }, (_, i) => `${i + 1}`);

    // Dados de gastos até o dia atual (linha sólida)
    const actualExpenses = [];
    for (let i = 0; i < currentDay; i++) {
        // Simulando gastos progressivos com alguma variação
        const baseExpense = (financialData.expenses / daysInMonth) * (i + 1);
        const variation = Math.random() * 200 - 100;
        actualExpenses.push(Math.max(0, baseExpense + variation));
    }

    // Dados de previsão (linha tracejada) - continua a tendência
    const projectedExpenses = [...actualExpenses];
    const dailyAverage = actualExpenses[actualExpenses.length - 1] / currentDay;

    for (let i = currentDay; i < daysInMonth; i++) {
        const projected = dailyAverage * (i + 1);
        projectedExpenses.push(projected);
    }

    return {
        labels,
        datasets: [
            {
                label: 'Gastos Realizados',
                data: actualExpenses.concat(Array(daysInMonth - currentDay).fill(null)),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 5,
            },
            {
                label: 'Previsão de Gastos',
                data: Array(currentDay).fill(null).concat(projectedExpenses.slice(currentDay)),
                borderColor: 'rgb(156, 163, 175)',
                backgroundColor: 'rgba(156, 163, 175, 0.05)',
                borderDash: [5, 5],
                tension: 0.4,
                fill: true,
                pointRadius: 2,
                pointHoverRadius: 4,
            },
        ],
    };
};

const chartData = ref(generateChartData());

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'top' as const,
        },
        tooltip: {
            mode: 'index' as const,
            intersect: false,
            callbacks: {
                label: (context: any) => {
                    let label = context.dataset.label || '';
                    if (label) {
                        label += ': ';
                    }
                    if (context.parsed.y !== null) {
                        label += new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL',
                        }).format(context.parsed.y);
                    }
                    return label;
                },
            },
        },
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: (value: any) => {
                    return new Intl.NumberFormat('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        minimumFractionDigits: 0,
                    }).format(value);
                },
            },
        },
        x: {
            grid: {
                display: false,
            },
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            <!-- Filtro de Meses -->
            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="(month, index) in months"
                    :key="index"
                    :variant="selectedMonth === index ? 'default' : 'outline'"
                    size="sm"
                    @click="selectedMonth = index"
                >
                    {{ month }}
                </Button>
            </div>

            <!-- Cards de Receitas e Despesas -->
            <div class="grid gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-sm font-medium text-muted-foreground">
                            Receitas do Mês
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-green-600 dark:text-green-500">
                            {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(financialData.income) }}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-sm font-medium text-muted-foreground">
                            Despesas do Mês
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold text-red-600 dark:text-red-500">
                            {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(financialData.expenses) }}
                        </div>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader>
                        <CardTitle class="text-sm font-medium text-muted-foreground">
                            Saldo
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div
                            class="text-2xl font-bold"
                            :class="balance >= 0 ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500'"
                        >
                            {{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(balance) }}
                        </div>
                    </CardContent>
                </Card>
            </div>

            <!-- Gráfico de Gastos -->
            <Card class="flex-1">
                <CardHeader>
                    <CardTitle>Gastos ao Longo do Mês - {{ months[selectedMonth] }}</CardTitle>
                </CardHeader>
                <CardContent class="h-[400px]">
                    <Line :data="chartData" :options="chartOptions" />
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
