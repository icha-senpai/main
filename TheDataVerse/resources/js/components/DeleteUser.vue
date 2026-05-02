<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { TriangleAlert } from 'lucide-vue-next';
import { useTemplateRef } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';

const passwordInput = useTemplateRef('passwordInput');
</script>

<template>
    <section class="overflow-hidden rounded-2xl border border-destructive/25 bg-destructive/10 p-6">
        <div class="mb-5 flex items-start gap-4">
            <div
                class="flex size-11 shrink-0 items-center justify-center rounded-xl border border-destructive/30 bg-destructive/10 text-destructive"
            >
                <TriangleAlert class="size-5" />
            </div>

            <div>
                <p class="mb-2 text-sm font-black uppercase tracking-[0.3em] text-destructive">
                    Danger zone
                </p>

                <h2 class="text-2xl font-black tracking-tight text-foreground">
                    Delete account
                </h2>

                <p class="mt-2 text-sm leading-6 text-muted-foreground">
                    Permanently delete your account and all account-owned resources.
                    This action cannot be undone.
                </p>
            </div>
        </div>

        <Dialog>
            <DialogTrigger as-child>
                <Button variant="destructive" data-test="delete-user-button">
                    Delete account
                </Button>
            </DialogTrigger>

            <DialogContent class="border-destructive/25">
                <Form
                    v-bind="ProfileController.destroy.form()"
                    reset-on-success
                    @error="() => passwordInput?.focus()"
                    :options="{
                        preserveScroll: true,
                    }"
                    class="space-y-6"
                    v-slot="{ errors, processing, reset, clearErrors }"
                >
                    <DialogHeader class="space-y-3">
                        <DialogTitle>
                            Are you sure you want to delete your account?
                        </DialogTitle>

                        <DialogDescription>
                            Once your account is deleted, all of its resources
                            and data will also be permanently deleted. Please
                            enter your password to confirm this action.
                        </DialogDescription>
                    </DialogHeader>

                    <div class="grid gap-2">
                        <Label for="password" class="sr-only">Password</Label>

                        <PasswordInput
                            id="password"
                            name="password"
                            ref="passwordInput"
                            placeholder="Password"
                        />

                        <InputError :message="errors.password" />
                    </div>

                    <DialogFooter class="gap-2">
                        <DialogClose as-child>
                            <Button
                                variant="secondary"
                                @click="
                                    () => {
                                        clearErrors();
                                        reset();
                                    }
                                "
                            >
                                Cancel
                            </Button>
                        </DialogClose>

                        <Button
                            type="submit"
                            variant="destructive"
                            :disabled="processing"
                            data-test="confirm-delete-user-button"
                        >
                            {{ processing ? 'Deleting...' : 'Delete account' }}
                        </Button>
                    </DialogFooter>
                </Form>
            </DialogContent>
        </Dialog>
    </section>
</template>