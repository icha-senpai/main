<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
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
            {
                title: 'Create',
                href: '/dashboard/datastream/create',
            },
        ],
    },
});

const form = useForm({
    title: '',
    slug: '',
    excerpt: '',
    body: '',
    status: 'draft',
});

const submit = () => {
    form.post('/dashboard/datastream');
};
</script>

<template>
    <Head title="Create Datastream Signal" />

    <div class="relative flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
        <section class="relative overflow-hidden rounded-2xl border border-dv-cyan/25 bg-dv-surface/80 p-6 shadow-[0_0_45px_rgba(91,19,236,0.25)]">
            <p class="mb-3 text-sm font-semibold uppercase tracking-[0.35em] text-dv-cyan">
                New public signal
            </p>

            <h1 class="dv-gradient-text dv-text-glow text-4xl font-black tracking-tight md:text-6xl">
                Create Datastream Post
            </h1>
        </section>

        <form class="dv-panel space-y-6 rounded-2xl p-6" @submit.prevent="submit">
            <div>
                <label class="mb-2 block text-sm font-bold text-dv-sky">
                    Title
                </label>

                <input
                    v-model="form.title"
                    type="text"
                    class="w-full rounded-xl border border-input bg-background/70 px-4 py-3 text-foreground outline-none transition focus:border-dv-cyan"
                    placeholder="Signal title"
                />

                <p v-if="form.errors.title" class="mt-2 text-sm text-destructive">
                    {{ form.errors.title }}
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-dv-sky">
                    Slug
                </label>

                <input
                    v-model="form.slug"
                    type="text"
                    class="w-full rounded-xl border border-input bg-background/70 px-4 py-3 text-foreground outline-none transition focus:border-dv-cyan"
                    placeholder="leave blank to auto-generate"
                />

                <p class="mt-2 text-xs text-muted-foreground">
                    Optional. Use lowercase words and dashes. Example: first-signal
                </p>

                <p v-if="form.errors.slug" class="mt-2 text-sm text-destructive">
                    {{ form.errors.slug }}
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-dv-sky">
                    Excerpt
                </label>

                <textarea
                    v-model="form.excerpt"
                    rows="3"
                    class="w-full rounded-xl border border-input bg-background/70 px-4 py-3 text-foreground outline-none transition focus:border-dv-cyan"
                    placeholder="Short public summary"
                ></textarea>

                <p v-if="form.errors.excerpt" class="mt-2 text-sm text-destructive">
                    {{ form.errors.excerpt }}
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-dv-sky">
                    Body
                </label>

                <textarea
                    v-model="form.body"
                    rows="14"
                    class="w-full rounded-xl border border-input bg-background/70 px-4 py-3 text-foreground outline-none transition focus:border-dv-cyan"
                    placeholder="Write the signal body..."
                ></textarea>

                <p v-if="form.errors.body" class="mt-2 text-sm text-destructive">
                    {{ form.errors.body }}
                </p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-dv-sky">
                    Status
                </label>

                <select
                    v-model="form.status"
                    class="w-full rounded-xl border border-input bg-background/70 px-4 py-3 text-foreground outline-none transition focus:border-dv-cyan"
                >
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>

                <p v-if="form.errors.status" class="mt-2 text-sm text-destructive">
                    {{ form.errors.status }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    type="submit"
                    class="rounded-full bg-dv-cyan px-6 py-3 text-sm font-black text-dv-void transition hover:bg-dv-sky disabled:opacity-50"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Creating...' : 'Create signal' }}
                </button>

                <Link
                    href="/dashboard/datastream"
                    class="rounded-full border border-dv-magenta/35 px-6 py-3 text-sm font-black text-dv-magenta transition hover:border-dv-cyan/45 hover:text-dv-cyan"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </div>
</template>