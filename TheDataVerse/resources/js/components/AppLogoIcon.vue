<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 64 64"
        :class="className"
        v-bind="$attrs"
        aria-hidden="true"
    >
        <defs>
            <linearGradient id="dv-logo-gradient" x1="8" y1="8" x2="56" y2="56">
                <stop offset="0%" stop-color="var(--dv-sky)" />
                <stop offset="35%" stop-color="var(--dv-cyan)" />
                <stop offset="68%" stop-color="var(--dv-violet)" />
                <stop offset="100%" stop-color="var(--dv-magenta)" />
            </linearGradient>

            <filter id="dv-logo-glow" x="-40%" y="-40%" width="180%" height="180%">
                <feGaussianBlur stdDeviation="2.2" result="blur" />
                <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                </feMerge>
            </filter>
        </defs>

        <circle
            cx="32"
            cy="32"
            r="27"
            fill="var(--dv-void)"
            stroke="url(#dv-logo-gradient)"
            stroke-width="3"
            filter="url(#dv-logo-glow)"
        />

        <path
            d="M18 18h13.5c8.5 0 14.5 5.6 14.5 14s-6 14-14.5 14H18V18Zm8 7v14h5.2c4.5 0 7.2-2.8 7.2-7s-2.7-7-7.2-7H26Z"
            fill="url(#dv-logo-gradient)"
        />

        <path
            d="M35 18h8l5.8 18.5L54.5 18H62L52.2 46h-7.1L35 18Z"
            fill="url(#dv-logo-gradient)"
            opacity="0.92"
        />

        <path
            d="M17 50c8-4.4 21.7-4.5 30 0"
            stroke="var(--dv-magenta)"
            stroke-width="2"
            stroke-linecap="round"
            opacity="0.75"
        />
    </svg>
</template>