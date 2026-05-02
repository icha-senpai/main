<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { dashboard, login, register } from '@/routes';

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);

const sections = [
    {
        title: 'Datastream',
        description: 'Personal posts, updates, logs, thoughts, and signal fragments.',
        status: 'First module',
    },
    {
        title: 'Archives',
        description: 'Books, music, movies, games, lore, and long-form memory systems.',
        status: 'Planned',
    },
    {
        title: 'Atlas',
        description: 'A public-facing slice of the world bible, mythology, and setting logic.',
        status: 'Planned',
    },
    {
        title: 'Star Citizen',
        description: 'Tools, cargo systems, ships, org utilities, and future UEX integrations.',
        status: 'Primed',
    },
];

const signals = [
    'Laravel 13 core',
    'Vue / Inertia interface',
    'Tailwind v4 theme layer',
    'PostgreSQL-backed future',
];
</script>

<template>
    <Head title="The DataVerse" />

    <div class="relative min-h-screen overflow-hidden bg-background text-foreground">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute left-[-12rem] top-[-12rem] size-[34rem] rounded-full bg-dv-cyan/20 blur-3xl"></div>
            <div class="absolute right-[-10rem] top-16 size-[34rem] rounded-full bg-dv-magenta/20 blur-3xl"></div>
            <div class="absolute bottom-[-16rem] left-1/3 size-[42rem] rounded-full bg-dv-violet/30 blur-3xl"></div>

            <div
                class="absolute inset-0 opacity-[0.08]"
                style="
                    background-image:
                        linear-gradient(to right, var(--dv-cyan) 1px, transparent 1px),
                        linear-gradient(to bottom, var(--dv-cyan) 1px, transparent 1px);
                    background-size: 52px 52px;
                "
            ></div>
        </div>

        <header class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
            <Link href="/" class="group inline-flex items-center gap-3">
                <div
                    class="flex size-11 items-center justify-center rounded-2xl border border-dv-cyan/35 bg-dv-surface/80 shadow-[0_0_28px_rgba(103,185,254,0.25)]"
                >
                    <span class="dv-gradient-text text-lg font-black">DV</span>
                </div>

                <div class="leading-none">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-dv-sky/75">
                        the
                    </p>
                    <p class="dv-gradient-text dv-text-glow text-xl font-black tracking-tight">
                        dataverse
                    </p>
                </div>
            </Link>

            <nav class="flex items-center gap-3">
                <Link
                    v-if="$page.props.auth.user"
                    :href="dashboard()"
                    class="rounded-full border border-dv-cyan/30 bg-dv-cyan/10 px-5 py-2 text-sm font-semibold text-dv-cyan shadow-[0_0_22px_rgba(103,185,254,0.18)] transition hover:border-dv-magenta/50 hover:bg-dv-magenta/10 hover:text-dv-magenta"
                >
                    Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="login()"
                        class="rounded-full border border-transparent px-5 py-2 text-sm font-semibold text-dv-sky transition hover:border-dv-cyan/30 hover:bg-dv-cyan/10 hover:text-dv-cyan"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="register()"
                        class="rounded-full border border-dv-magenta/35 bg-dv-magenta/10 px-5 py-2 text-sm font-semibold text-dv-magenta shadow-[0_0_22px_rgba(234,70,229,0.18)] transition hover:border-dv-cyan/45 hover:bg-dv-cyan/10 hover:text-dv-cyan"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>

        <main class="relative z-10 mx-auto flex min-h-[calc(100vh-6rem)] w-full max-w-7xl flex-col px-6 pb-10 pt-10 lg:px-8 lg:pt-20">
            <section class="grid flex-1 items-center gap-12 lg:grid-cols-[1.05fr_0.95fr]">
                <div>
                    <p class="mb-5 text-sm font-bold uppercase tracking-[0.45em] text-dv-cyan">
                        Fresh signal detected
                    </p>

                    <h1 class="max-w-4xl text-5xl font-black tracking-tight md:text-7xl lg:text-8xl">
                        <span class="block text-dv-ice">Enter</span>
                        <span class="dv-gradient-text dv-text-glow block">The DataVerse</span>
                    </h1>

                    <p class="mt-7 max-w-2xl text-lg leading-8 text-dv-sky/85">
                        A personal digital nexus for systems, stories, games, media, tools,
                        archives, and whatever strange little cyber-magic crawls out of the walls next.
                    </p>

                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="dashboard()"
                            class="inline-flex items-center justify-center rounded-full bg-dv-cyan px-7 py-3 text-sm font-black text-dv-void shadow-[0_0_32px_rgba(103,185,254,0.35)] transition hover:-translate-y-0.5 hover:bg-dv-sky"
                        >
                            Open dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="login()"
                                class="inline-flex items-center justify-center rounded-full bg-dv-cyan px-7 py-3 text-sm font-black text-dv-void shadow-[0_0_32px_rgba(103,185,254,0.35)] transition hover:-translate-y-0.5 hover:bg-dv-sky"
                            >
                                Enter system
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="register()"
                                class="inline-flex items-center justify-center rounded-full border border-dv-magenta/45 bg-dv-magenta/10 px-7 py-3 text-sm font-black text-dv-magenta transition hover:-translate-y-0.5 hover:border-dv-cyan/50 hover:text-dv-cyan"
                            >
                                Create account
                            </Link>
                        </template>
                    </div>

                    <div class="mt-10 grid max-w-2xl gap-3 sm:grid-cols-2">
                        <div
                            v-for="signal in signals"
                            :key="signal"
                            class="rounded-2xl border border-dv-cyan/20 bg-dv-surface/60 px-4 py-3 text-sm font-semibold text-dv-sky/85 shadow-[inset_0_0_18px_rgba(103,185,254,0.05)]"
                        >
                            {{ signal }}
                        </div>
                    </div>
                </div>

                <div class="dv-panel relative overflow-hidden rounded-[2rem] p-6 lg:p-8">
                    <div class="absolute -right-20 -top-20 size-64 rounded-full bg-dv-magenta/25 blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 size-64 rounded-full bg-dv-cyan/25 blur-3xl"></div>

                    <div class="relative z-10">
                        <div class="mb-8 rounded-3xl border border-dv-cyan/25 bg-dv-void/50 p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.4em] text-dv-magenta">
                                Core identity
                            </p>

                            <p class="dv-gradient-text dv-text-glow mt-4 text-5xl font-black tracking-tight md:text-6xl">
                                dataverse
                            </p>

                            <p class="mt-4 text-sm leading-6 text-muted-foreground">
                                Not a CMS skin. Not a borrowed framework personality.
                                A custom Laravel-built home for the whole stack.
                            </p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <article
                                v-for="section in sections"
                                :key="section.title"
                                class="group rounded-2xl border border-dv-cyan/15 bg-dv-void/45 p-5 transition hover:-translate-y-1 hover:border-dv-magenta/40 hover:bg-dv-violet/10"
                            >
                                <div class="mb-4 flex items-center justify-between gap-3">
                                    <h2 class="font-black text-foreground">
                                        {{ section.title }}
                                    </h2>

                                    <span class="rounded-full border border-dv-cyan/20 bg-dv-cyan/10 px-2.5 py-1 text-[0.65rem] font-bold uppercase tracking-wider text-dv-cyan">
                                        {{ section.status }}
                                    </span>
                                </div>

                                <p class="text-sm leading-6 text-muted-foreground">
                                    {{ section.description }}
                                </p>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>