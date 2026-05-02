<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';
import SecurityController from '@/actions/App/Http/Controllers/Settings/SecurityController';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import { edit } from '@/routes/security';
import { disable, enable } from '@/routes/two-factor';

type Props = {
    canManageTwoFactor?: boolean;
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

withDefaults(defineProps<Props>(), {
    canManageTwoFactor: false,
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Security settings',
                href: edit(),
            },
        ],
    },
});

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => clearTwoFactorAuthData());
</script>

<template>
    <Head title="Security settings" />

    <h1 class="sr-only">Security settings</h1>

    <section class="dv-panel overflow-hidden rounded-2xl p-6">
        <div class="mb-6">
            <p class="mb-2 text-sm font-black uppercase tracking-[0.3em] text-dv-cyan">
                Access control
            </p>

            <h2 class="text-2xl font-black tracking-tight text-foreground">
                Update password
            </h2>

            <p class="mt-2 text-sm leading-6 text-muted-foreground">
                Keep the gate locked with a strong password.
            </p>
        </div>

        <Form
            v-bind="SecurityController.update.form()"
            :options="{
                preserveScroll: true,
            }"
            reset-on-success
            :reset-on-error="[
                'password',
                'password_confirmation',
                'current_password',
            ]"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="current_password" class="text-dv-sky">
                    Current password
                </Label>

                <PasswordInput
                    id="current_password"
                    name="current_password"
                    class="mt-1 block w-full border-input bg-background/70"
                    autocomplete="current-password"
                    placeholder="Current password"
                />

                <InputError :message="errors.current_password" />
            </div>

            <div class="grid gap-2">
                <Label for="password" class="text-dv-sky">
                    New password
                </Label>

                <PasswordInput
                    id="password"
                    name="password"
                    class="mt-1 block w-full border-input bg-background/70"
                    autocomplete="new-password"
                    placeholder="New password"
                />

                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation" class="text-dv-sky">
                    Confirm password
                </Label>

                <PasswordInput
                    id="password_confirmation"
                    name="password_confirmation"
                    class="mt-1 block w-full border-input bg-background/70"
                    autocomplete="new-password"
                    placeholder="Confirm password"
                />

                <InputError :message="errors.password_confirmation" />
            </div>

            <div class="flex items-center gap-4">
                <Button
                    :disabled="processing"
                    data-test="update-password-button"
                    class="bg-dv-cyan font-black text-dv-void hover:bg-dv-sky"
                >
                    {{ processing ? 'Saving...' : 'Save password' }}
                </Button>
            </div>
        </Form>
    </section>

    <section
        v-if="canManageTwoFactor"
        class="dv-panel overflow-hidden rounded-2xl p-6"
    >
        <div class="mb-6">
            <p class="mb-2 text-sm font-black uppercase tracking-[0.3em] text-dv-magenta">
                Second lock
            </p>

            <h2 class="text-2xl font-black tracking-tight text-foreground">
                Two-factor authentication
            </h2>

            <p class="mt-2 text-sm leading-6 text-muted-foreground">
                Add a second verification step to protect your account.
            </p>
        </div>

        <div
            v-if="!twoFactorEnabled"
            class="flex flex-col items-start justify-start space-y-4 rounded-xl border border-dv-cyan/20 bg-dv-void/45 p-4"
        >
            <p class="text-sm leading-6 text-muted-foreground">
                When you enable two-factor authentication, you will be prompted
                for a secure pin during login. This pin can be retrieved from a
                TOTP-supported application on your phone.
            </p>

            <div>
                <Button
                    v-if="hasSetupData"
                    class="bg-dv-cyan font-black text-dv-void hover:bg-dv-sky"
                    @click="showSetupModal = true"
                >
                    <ShieldCheck />
                    Continue setup
                </Button>

                <Form
                    v-else
                    v-bind="enable.form()"
                    @success="showSetupModal = true"
                    #default="{ processing }"
                >
                    <Button
                        type="submit"
                        :disabled="processing"
                        class="bg-dv-cyan font-black text-dv-void hover:bg-dv-sky"
                    >
                        Enable 2FA
                    </Button>
                </Form>
            </div>
        </div>

        <div
            v-else
            class="flex flex-col items-start justify-start space-y-4 rounded-xl border border-dv-cyan/20 bg-dv-void/45 p-4"
        >
            <p class="text-sm leading-6 text-muted-foreground">
                Two-factor authentication is enabled. You will be prompted for
                a secure, random pin during login.
            </p>

            <div class="relative inline">
                <Form v-bind="disable.form()" #default="{ processing }">
                    <Button
                        variant="destructive"
                        type="submit"
                        :disabled="processing"
                    >
                        Disable 2FA
                    </Button>
                </Form>
            </div>

            <TwoFactorRecoveryCodes />
        </div>

        <TwoFactorSetupModal
            v-model:isOpen="showSetupModal"
            :requiresConfirmation="requiresConfirmation"
            :twoFactorEnabled="twoFactorEnabled"
        />
    </section>
</template>