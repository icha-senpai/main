<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { dashboard } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
            {
                title: 'Datastream',
                href: '/dashboard/datastream',
            },
        ],
    },
});

type ManagedPost = {
    id: number;
    title: string;
    slug: string;
    status: string;
    published_at: string | null;
    created_at: string | null;
    author: {
        name: string | null;
    };
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

defineProps<{
    posts: {
        data: ManagedPost[];
        links: PaginationLink[];
    };
}>();

const formatDate = (value: string | null) => {
    if (!value) {
        return 'Not published';
    }

    return new Intl.DateTimeFormat('en-US', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
};

const deletePost = (post: ManagedPost) => {
    if (!confirm(`Archive "${post.title}"?`)) {
        return;
    }

    router.delete(`/dashboard/datastream/${post.id}`);
};
</script>

<template>
    <Head title="Manage Datastream" />

    <div class="relative flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
        <section class="relative overflow-hidden rounded-2xl border border-dv-cyan/25 bg-dv-surface/80 p-6 shadow-[0_0_45px_rgba(91,19,236,0.25)]">
            <div class="relative z-10 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.35em] text-dv-cyan">
                        Admin signal control
                    </p>

                    <h1 class="dv-gradient-text dv-text-glow text-4xl font-black tracking-tight md:text-6xl">
                        Datastream
                    </h1>

                    <p class="mt-4 max-w-2xl text-sm leading-6 text-dv-sky/85">
                        Create, draft, publish, and archive public DataVerse signals.
                    </p>
                </div>

                <Link
                    href="/dashboard/datastream/create"
                    class="inline-flex w-fit rounded-full bg-dv-cyan px-6 py-3 text-sm font-black text-dv-void shadow-[0_0_28px_rgba(103,185,254,0.25)] transition hover:bg-dv-sky"
                >
                    New signal
                </Link>
            </div>
        </section>

        <section class="dv-panel overflow-hidden rounded-2xl">
            <div v-if="posts.data.length" class="divide-y divide-border/60">
                <article
                    v-for="post in posts.data"
                    :key="post.id"
                    class="grid gap-4 p-5 md:grid-cols-[1fr_auto] md:items-center"
                >
                    <div>
                        <div class="mb-2 flex flex-wrap items-center gap-3">
                            <span
                                class="rounded-full border px-3 py-1 text-xs font-bold uppercase tracking-wider"
                                :class="
                                    post.status === 'published'
                                        ? 'border-dv-cyan/35 bg-dv-cyan/10 text-dv-cyan'
                                        : 'border-dv-magenta/35 bg-dv-magenta/10 text-dv-magenta'
                                "
                            >
                                {{ post.status }}
                            </span>

                            <span class="text-xs text-muted-foreground">
                                {{ formatDate(post.published_at) }}
                            </span>
                        </div>

                        <h2 class="text-xl font-black text-foreground">
                            {{ post.title }}
                        </h2>

                        <p class="mt-1 text-sm text-muted-foreground">
                            /datastream/{{ post.slug }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <Link
                            :href="`/datastream/${post.slug}`"
                            class="rounded-full border border-dv-cyan/25 px-4 py-2 text-sm font-bold text-dv-cyan transition hover:border-dv-magenta/45 hover:text-dv-magenta"
                        >
                            View
                        </Link>

                        <Link
                            :href="`/dashboard/datastream/${post.id}/edit`"
                            class="rounded-full border border-dv-violet/35 px-4 py-2 text-sm font-bold text-dv-purple transition hover:border-dv-cyan/45 hover:text-dv-cyan"
                        >
                            Edit
                        </Link>

                        <button
                            type="button"
                            class="rounded-full border border-destructive/35 px-4 py-2 text-sm font-bold text-destructive transition hover:bg-destructive/10"
                            @click="deletePost(post)"
                        >
                            Archive
                        </button>
                    </div>
                </article>
            </div>

            <div v-else class="p-10 text-center">
                <p class="text-sm font-bold uppercase tracking-[0.35em] text-dv-magenta">
                    No signals yet
                </p>

                <h2 class="mt-4 text-3xl font-black">
                    Create the first Datastream post.
                </h2>

                <Link
                    href="/dashboard/datastream/create"
                    class="mt-6 inline-flex rounded-full bg-dv-cyan px-6 py-3 text-sm font-black text-dv-void"
                >
                    New signal
                </Link>
            </div>
        </section>

        <div
            v-if="posts.links.length > 3"
            class="flex flex-wrap justify-center gap-2"
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
    </div>
</template>