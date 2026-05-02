<script setup lang="ts">
import { Monitor, Moon, Sun } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

const { appearance, updateAppearance } = useAppearance();

const tabs = [
    { value: 'light', Icon: Sun, label: 'Light' },
    { value: 'dark', Icon: Moon, label: 'Dark' },
    { value: 'system', Icon: Monitor, label: 'System' },
] as const;
</script>

<template>
    <div
        class="inline-flex gap-1 rounded-xl border border-dv-cyan/20 bg-dv-void/55 p-1 shadow-[inset_0_0_18px_rgba(103,185,254,0.05)]"
    >
        <button
            v-for="{ value, Icon, label } in tabs"
            :key="value"
            type="button"
            @click="updateAppearance(value)"
            :class="[
                'group flex items-center rounded-lg px-3.5 py-2 text-sm font-bold transition-all duration-200',
                appearance === value
                    ? 'bg-dv-cyan text-dv-void shadow-[0_0_22px_rgba(103,185,254,0.35)]'
                    : 'text-muted-foreground hover:bg-dv-magenta/10 hover:text-dv-magenta hover:shadow-[0_0_18px_rgba(234,70,229,0.16)]',
            ]"
        >
            <component
                :is="Icon"
                class="-ml-1 h-4 w-4 transition-colors"
                :class="
                    appearance === value
                        ? 'text-dv-void'
                        : 'text-dv-sky/65 group-hover:text-dv-magenta'
                "
            />

            <span class="ml-1.5">{{ label }}</span>
        </button>
    </div>
</template>