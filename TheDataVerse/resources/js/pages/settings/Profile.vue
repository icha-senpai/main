<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import DeleteUser from '@/components/DeleteUser.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Profile settings',
                href: edit(),
            },
        ],
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Profile settings" />

    <h1 class="sr-only">Profile settings</h1>

    <section class="dv-panel overflow-hidden rounded-2xl p-6">
        <div class="mb-6">
            <p class="mb-2 text-sm font-black uppercase tracking-[0.3em] text-dv-cyan">
                Identity record
            </p>

            <h2 class="text-2xl font-black tracking-tight text-foreground">
                Profile information
            </h2>

            <p class="mt-2 text-sm leading-6 text-muted-foreground">
                Update the name and email address attached to your DataVerse account.
            </p>
        </div>

        <Form
            v-bind="ProfileController.update.form()"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="name" class="text-dv-sky">Name</Label>

                <Input
                    id="name"
                    class="mt-1 block w-full border-input bg-background/70"
                    name="name"
                    :default-value="user.name"
                    required
                    autocomplete="name"
                    placeholder="Full name"
                />

                <InputError class="mt-2" :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email" class="text-dv-sky">Email address</Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-input bg-background/70"
                    name="email"
                    :default-value="user.email"
                    required
                    autocomplete="username"
                    placeholder="Email address"
                />

                <InputError class="mt-2" :message="errors.email" />
            </div>

            <div
                v-if="mustVerifyEmail && !user.email_verified_at"
                class="rounded-xl border border-dv-magenta/25 bg-dv-magenta/10 p-4"
            >
                <p class="text-sm leading-6 text-muted-foreground">
                    Your email address is unverified.
                    <Link
                        :href="send()"
                        as="button"
                        class="font-bold text-dv-magenta underline decoration-dv-magenta/40 underline-offset-4 transition hover:text-dv-cyan hover:decoration-dv-cyan"
                    >
                        Click here to resend the verification email.
                    </Link>
                </p>

                <div
                    v-if="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-bold text-dv-cyan"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button
                    :disabled="processing"
                    data-test="update-profile-button"
                    class="bg-dv-cyan font-black text-dv-void hover:bg-dv-sky"
                >
                    {{ processing ? 'Saving...' : 'Save profile' }}
                </Button>
            </div>
        </Form>
    </section>

    <DeleteUser />
</template>