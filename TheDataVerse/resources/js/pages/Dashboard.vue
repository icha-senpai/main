<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});

const systemCards = [
    {
        title: 'Datastream',
        value: 'Online',
        description: 'Personal logs, updates, and signal fragments.',
    },
    {
        title: 'Archives',
        value: 'Dormant',
        description: 'Books, media, lore, and long-term memory systems.',
    },
    {
        title: 'Operations',
        value: 'Primed',
        description: 'Future Star Citizen tools, trackers, and dashboards.',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <div class="relative flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
        <div
            class="pointer-events-none absolute inset-0 overflow-hidden rounded-xl"
            aria-hidden="true"
        >
            <div class="absolute left-8 top-8 size-72 rounded-full bg-dv-cyan/10 blur-3xl"></div>
            <div class="absolute right-8 top-20 size-80 rounded-full bg-dv-magenta/10 blur-3xl"></div>
            <div class="absolute bottom-8 left-1/3 size-96 rounded-full bg-dv-violet/20 blur-3xl"></div>
        </div>

        <section class="relative overflow-hidden rounded-2xl border border-dv-cyan/25 bg-dv-surface/80 p-6 shadow-[0_0_45px_rgba(91,19,236,0.25)]">
            <PlaceholderPattern />

            <div class="relative z-10 max-w-4xl">
                <p class="mb-3 text-sm font-semibold uppercase tracking-[0.35em] text-dv-cyan">
                    System boot complete
                </p>

                <h1 class="dv-gradient-text dv-text-glow text-4xl font-black tracking-tight md:text-6xl">
                    The DataVerse
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-7 text-dv-sky/85 md:text-lg">
                    A fresh Laravel core is online. No October. No Twig. No haunted CMS goblin maze.
                    This is the clean control room for the new build.
                </p>
            </div>
        </section>

        <section class="relative grid auto-rows-min gap-4 md:grid-cols-3">
            <article
                v-for="card in systemCards"
                :key="card.title"
                class="dv-panel group relative overflow-hidden rounded-2xl p-5 transition duration-300 hover:-translate-y-1 hover:border-dv-magenta/50"
            >
                <PlaceholderPattern />

                <div class="relative z-10">
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h2 class="text-sm font-bold uppercase tracking-[0.25em] text-dv-sky">
                            {{ card.title }}
                        </h2>

                        <span class="rounded-full border border-dv-cyan/30 bg-dv-cyan/10 px-3 py-1 text-xs font-semibold text-dv-cyan">
                            {{ card.value }}
                        </span>
                    </div>

                    <p class="text-sm leading-6 text-foreground/75">
                        {{ card.description }}
                    </p>
                </div>
            </article>
        </section>

        <section class="dv-panel relative min-h-[28rem] flex-1 overflow-hidden rounded-2xl p-6">
            <PlaceholderPattern />

            <div class="relative z-10 grid h-full gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="flex flex-col justify-between gap-8">
                    <div>
                        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.35em] text-dv-magenta">
                            Foundation status
                        </p>

                        <h2 class="text-3xl font-black tracking-tight text-foreground md:text-4xl">
                            Clean core. Fresh shell. Ready for the first real module.
                        </h2>

                        <p class="mt-5 max-w-2xl text-base leading-7 text-muted-foreground">
                            The next layer should be the DataVerse identity shell: public homepage,
                            app navigation, visual language, and then the Datastream content engine.
                        </p>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-xl border border-dv-cyan/20 bg-dv-void/45 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-dv-sky/70">
                                Stack
                            </p>
                            <p class="mt-2 text-lg font-bold text-dv-cyan">
                                Laravel
                            </p>
                        </div>

                        <div class="rounded-xl border border-dv-violet/25 bg-dv-void/45 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-dv-sky/70">
                                Frontend
                            </p>
                            <p class="mt-2 text-lg font-bold text-dv-purple">
                                Vue / Inertia
                            </p>
                        </div>

                        <div class="rounded-xl border border-dv-magenta/25 bg-dv-void/45 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-dv-sky/70">
                                Theme
                            </p>
                            <p class="mt-2 text-lg font-bold text-dv-magenta">
                                Neon Core
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-dv-cyan/20 bg-dv-void/55 p-5">
                    <p class="mb-4 text-sm font-bold uppercase tracking-[0.25em] text-dv-cyan">
                        Next build order
                    </p>

                    <ol class="space-y-4 text-sm text-foreground/80">
                        <li class="flex gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-dv-cyan/15 text-xs font-black text-dv-cyan">
                                1
                            </span>
                            <span>Rebrand layout, navigation, and dashboard shell.</span>
                        </li>

                        <li class="flex gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-dv-violet/20 text-xs font-black text-dv-purple">
                                2
                            </span>
                            <span>Create the public homepage and section cards.</span>
                        </li>

                        <li class="flex gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-dv-magenta/15 text-xs font-black text-dv-magenta">
                                3
                            </span>
                            <span>Build Datastream posts: model, migration, CRUD, index, and show pages.</span>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
    </div>
</template>