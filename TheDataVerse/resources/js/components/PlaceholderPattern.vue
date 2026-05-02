<script setup lang="ts">
import { useId } from 'vue';

const patternId = `pattern-${useId()}`;
const glowId = `glow-${useId()}`;
</script>

<template>
    <svg
        class="pointer-events-none absolute inset-0 size-full"
        fill="none"
        aria-hidden="true"
    >
        <defs>
            <linearGradient :id="glowId" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="var(--dv-cyan)" stop-opacity="0.22" />
                <stop offset="50%" stop-color="var(--dv-violet)" stop-opacity="0.16" />
                <stop offset="100%" stop-color="var(--dv-magenta)" stop-opacity="0.20" />
            </linearGradient>

            <pattern
                :id="patternId"
                x="0"
                y="0"
                width="18"
                height="18"
                patternUnits="userSpaceOnUse"
            >
                <path
                    d="M-1 10L10 -1M8 20L20 8"
                    stroke="url(#glowId)"
                    stroke-width="0.75"
                />
            </pattern>
        </defs>

        <rect
            stroke="none"
            :fill="`url(#${patternId})`"
            width="100%"
            height="100%"
        />

        <rect
            stroke="none"
            fill="var(--dv-void)"
            opacity="0.42"
            width="100%"
            height="100%"
        />
    </svg>
</template>