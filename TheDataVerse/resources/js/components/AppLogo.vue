<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <div
        class="flex aspect-square size-9 items-center justify-center rounded-xl border border-dv-cyan/30 bg-dv-surface shadow-[0_0_22px_rgba(103,185,254,0.22)]"
    >
        <AppLogoIcon class="size-6" />
    </div>

    <div class="ml-2 grid flex-1 text-left text-sm leading-tight">
        <span class="dv-gradient-text truncate font-black tracking-tight">
            The DataVerse
        </span>
        <span class="truncate text-xs font-medium text-sidebar-foreground/60">
            Signal Core
        </span>
    </div>
</template>