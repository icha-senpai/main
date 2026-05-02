<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import { edit } from '@/routes/appearance';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Appearance settings',
                href: edit(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Appearance settings" />

    <h1 class="sr-only">Appearance settings</h1>

    <section class="dv-panel overflow-hidden rounded-2xl p-6">
        <div class="mb-6">
            <p class="mb-2 text-sm font-black uppercase tracking-[0.3em] text-dv-magenta">
                Interface mood
            </p>

            <h2 class="text-2xl font-black tracking-tight text-foreground">
                Appearance settings
            </h2>

            <p class="mt-2 text-sm leading-6 text-muted-foreground">
                Adjust how the DataVerse interface presents itself.
            </p>
        </div>

        <div class="rounded-xl border border-dv-cyan/20 bg-dv-void/45 p-4">
            <AppearanceTabs />
        </div>
    </section>
</template>