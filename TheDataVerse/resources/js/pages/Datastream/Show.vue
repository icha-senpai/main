<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

type DatastreamPost = {
    id: number;
    title: string;
    slug: string;
    excerpt: string | null;
    body: string;
    status: string;
    published_at: string | null;
    author: {
        name: string | null;
    };
};

const props = defineProps<{
    post: DatastreamPost;
}>();

const publishedLabel = computed(() => {
    if (!props.post.published_at) {
        return 'Draft signal';
    }

    return new Intl.DateTimeFormat('en-US', {
        dateStyle: 'full',
        timeStyle: 'short',
    }).format(new Date(props.post.published_at));
});
</script>

<template>
    <Head :title="post.title" />

    <div class="relative min-h-screen overflow-hidden px-6 py-10 text-foreground lg:px-8">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute left-[-10rem] top-[-10rem] size-[30rem] rounded-full bg-dv-cyan/15 blur-3xl"></div>
            <div class="absolute right-[-8rem] top-20 size-[28rem] rounded-full bg-dv-magenta/15 blur-3xl"></div>
            <div class="absolute bottom-[-14rem] left-1/3 size-[36rem] rounded-full bg-dv-violet/25 blur-3xl"></div>
        </div>

        <main class="relative z-10 mx-auto max-w-4xl">
            <Link
                href="/datastream"
                class="mb-8 inline-flex rounded-full border border-dv-cyan/35 bg-dv-cyan/10 px-5 py-2 text-sm font-bold text-dv-cyan transition hover:border-dv-magenta/45 hover:text-dv-magenta"
            >
                ← Back to Datastream
            </Link>

            <article class="dv-panel overflow-hidden rounded-3xl p-8 md:p-10">
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.35em] text-dv-cyan">
                    {{ publishedLabel }}
                </p>

                <h1 class="dv-gradient-text dv-text-glow text-4xl font-black tracking-tight md:text-6xl">
                    {{ post.title }}
                </h1>

                <p
                    v-if="post.excerpt"
                    class="mt-6 border-l-2 border-dv-magenta/60 pl-5 text-lg leading-8 text-dv-sky/85"
                >
                    {{ post.excerpt }}
                </p>

                <div
                    class="mt-10 whitespace-pre-line text-base leading-8 text-foreground/85"
                >
                    {{ post.body }}
                </div>
            </article>
        </main>
    </div>
</template>