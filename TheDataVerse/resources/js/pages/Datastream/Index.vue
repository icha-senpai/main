<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

type DatastreamPost = {
    id: number;
    title: string;
    slug: string;
    excerpt: string | null;
    published_at: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

defineProps<{
    posts: {
        data: DatastreamPost[];
        links: PaginationLink[];
    };
}>();

const formatDate = (value: string | null) => {
    if (!value) {
        return 'Unscheduled signal';
    }

    return new Intl.DateTimeFormat('en-US', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
};
</script>

<template>
    <Head title="Datastream" />

    <div class="relative min-h-screen overflow-hidden px-6 py-10 text-foreground lg:px-8">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute left-[-10rem] top-[-10rem] size-[30rem] rounded-full bg-dv-cyan/15 blur-3xl"></div>
            <div class="absolute right-[-8rem] top-20 size-[28rem] rounded-full bg-dv-magenta/15 blur-3xl"></div>
            <div class="absolute bottom-[-14rem] left-1/3 size-[36rem] rounded-full bg-dv-violet/25 blur-3xl"></div>
        </div>

        <main class="relative z-10 mx-auto max-w-7xl">
            <div class="mb-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="mb-3 text-sm font-bold uppercase tracking-[0.4em] text-dv-cyan">
                        Public signal archive
                    </p>

                    <h1 class="dv-gradient-text dv-text-glow text-5xl font-black tracking-tight md:text-7xl">
                        Datastream
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-7 text-dv-sky/85">
                        Personal logs, updates, system notes, and fragments from the living edge of the DataVerse.
                    </p>
                </div>

                <Link
                    href="/"
                    class="inline-flex w-fit items-center justify-center rounded-full border border-dv-cyan/35 bg-dv-cyan/10 px-5 py-2 text-sm font-bold text-dv-cyan transition hover:border-dv-magenta/45 hover:text-dv-magenta"
                >
                    Return gateway
                </Link>
            </div>

            <section
                v-if="posts.data.length"
                class="grid gap-5 md:grid-cols-2 xl:grid-cols-3"
            >
                <article
                    v-for="post in posts.data"
                    :key="post.id"
                    class="dv-panel group relative overflow-hidden rounded-2xl p-6 transition duration-300 hover:-translate-y-1 hover:border-dv-magenta/45"
                >
                    <div class="relative z-10">
                        <p class="mb-4 text-xs font-bold uppercase tracking-[0.28em] text-dv-cyan/80">
                            {{ formatDate(post.published_at) }}
                        </p>

                        <h2 class="text-2xl font-black tracking-tight text-foreground">
                            {{ post.title }}
                        </h2>

                        <p class="mt-4 line-clamp-4 text-sm leading-6 text-muted-foreground">
                            {{ post.excerpt || 'No excerpt provided. Signal body available inside.' }}
                        </p>

                        <Link
                            :href="`/datastream/${post.slug}`"
                            class="mt-6 inline-flex rounded-full bg-dv-cyan px-5 py-2 text-sm font-black text-dv-void transition hover:bg-dv-sky"
                        >
                            Read signal
                        </Link>
                    </div>
                </article>
            </section>

            <section
                v-else
                class="dv-panel rounded-3xl p-10 text-center"
            >
                <p class="text-sm font-bold uppercase tracking-[0.35em] text-dv-magenta">
                    No public signals yet
                </p>

                <h2 class="mt-4 text-3xl font-black text-foreground">
                    The Datastream is quiet.
                </h2>

                <p class="mx-auto mt-4 max-w-xl text-muted-foreground">
                    Once published posts exist, they will appear here.
                </p>
            </section>

            <div
                v-if="posts.links.length > 3"
                class="mt-8 flex flex-wrap justify-center gap-2"
            >
                <template v-for="link in posts.links" :key="link.label">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="rounded-full border px-4 py-2 text-sm font-semibold transition"
                        :class="
                            link.active
                                ? 'border-dv-cyan bg-dv-cyan text-dv-void'
                                : 'border-dv-cyan/25 bg-dv-surface/70 text-dv-sky hover:border-dv-magenta/45 hover:text-dv-magenta'
                        "
                    >
                        <span v-html="link.label"></span>
                    </Link>
                </template>
            </div>
        </main>
    </div>
</template>