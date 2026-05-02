<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentOrParentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarGroup class="px-2 py-1">
        <SidebarGroupLabel
            class="px-3 text-[0.68rem] font-black uppercase tracking-[0.28em] text-dv-sky/45"
        >
            Platform
        </SidebarGroupLabel>

        <SidebarMenu class="mt-1 space-y-1">
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentOrParentUrl(item.href)"
                    :tooltip="item.title"
                    class="group/nav relative h-9 rounded-xl px-3 text-[0.86rem] font-semibold text-sidebar-foreground/68 transition-all duration-200 hover:bg-dv-cyan/8 hover:text-dv-sky data-[active=true]:bg-dv-cyan/10 data-[active=true]:text-dv-cyan data-[active=true]:shadow-[inset_0_0_18px_rgba(103,185,254,0.08),0_0_18px_rgba(103,185,254,0.08)] [&>svg]:size-4 [&>svg]:text-sidebar-foreground/45 [&>svg]:transition-colors hover:[&>svg]:text-dv-sky data-[active=true]:[&>svg]:text-dv-cyan"
                >
                    <Link :href="item.href" class="relative">
                        <span
                            v-if="isCurrentOrParentUrl(item.href)"
                            class="absolute -left-2 top-1/2 h-5 w-0.5 -translate-y-1/2 rounded-full bg-dv-cyan shadow-[0_0_12px_rgba(103,185,254,0.85)]"
                            aria-hidden="true"
                        />

                        <component :is="item.icon" />

                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>