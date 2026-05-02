<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Palette, ShieldCheck, UserRound } from 'lucide-vue-next';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { toUrl } from '@/lib/utils';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editProfile } from '@/routes/profile';
import { edit as editSecurity } from '@/routes/security';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: editProfile(),
        icon: UserRound,
    },
    {
        title: 'Security',
        href: editSecurity(),
        icon: ShieldCheck,
    },
    {
        title: 'Appearance',
        href: editAppearance(),
        icon: Palette,
    },
];

const { isCurrentOrParentUrl } = useCurrentUrl();
</script>

<template>
    <div class="relative px-4 py-6">
        <div class="pointer-events-none absolute inset-0 overflow-hidden rounded-xl" aria-hidden="true">
            <div class="absolute right-10 top-6 size-72 rounded-full bg-dv-cyan/8 blur-3xl"></div>
            <div class="absolute bottom-10 left-10 size-80 rounded-full bg-dv-violet/14 blur-3xl"></div>
        </div>

        <div class="relative z-10 mb-8">
            <p class="mb-3 text-sm font-black uppercase tracking-[0.35em] text-dv-cyan">
                Account console
            </p>

            <h1 class="dv-gradient-text dv-text-glow text-4xl font-black tracking-tight md:text-5xl">
                Settings
            </h1>

            <p class="mt-4 max-w-2xl text-sm leading-6 text-muted-foreground">
                Manage your DataVerse identity, security, and interface preferences.
            </p>
        </div>

        <div class="relative z-10 flex flex-col gap-8 lg:flex-row lg:gap-10">
            <aside class="w-full lg:w-56">
                <nav
                    class="dv-panel flex flex-col gap-1 rounded-2xl p-2"
                    aria-label="Settings"
                >
                    <Link
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        :href="item.href"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition-all duration-200"
                        :class="
                            isCurrentOrParentUrl(item.href)
                                ? 'bg-dv-cyan/10 text-dv-cyan shadow-[inset_0_0_18px_rgba(103,185,254,0.08),0_0_18px_rgba(103,185,254,0.08)]'
                                : 'text-sidebar-foreground/65 hover:bg-dv-cyan/8 hover:text-dv-sky'
                        "
                    >
                        <component
                            :is="item.icon"
                            class="size-4 transition-colors"
                            :class="
                                isCurrentOrParentUrl(item.href)
                                    ? 'text-dv-cyan'
                                    : 'text-sidebar-foreground/40 group-hover:text-dv-sky'
                            "
                        />

                        <span>{{ item.title }}</span>
                    </Link>
                </nav>
            </aside>

            <Separator class="lg:hidden" />

            <section class="w-full max-w-3xl space-y-8">
                <slot />
            </section>
        </div>
    </div>
</template>