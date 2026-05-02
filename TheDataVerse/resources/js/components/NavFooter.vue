<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { toUrl } from '@/lib/utils';
import type { NavItem } from '@/types';

type Props = {
    items: NavItem[];
    class?: string;
};

defineProps<Props>();

const isExternalHref = (href: NavItem['href']) => {
    return (
        typeof href === 'string' &&
        (href.startsWith('http://') || href.startsWith('https://'))
    );
};
</script>

<template>
    <SidebarGroup
        :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`"
    >
        <SidebarGroupContent>
            <SidebarMenu class="space-y-1">
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton
                        class="h-8 rounded-xl px-3 text-[0.8rem] font-medium text-sidebar-foreground/48 transition-all duration-200 hover:bg-dv-violet/10 hover:text-dv-sky [&>svg]:size-4 [&>svg]:text-sidebar-foreground/35 hover:[&>svg]:text-dv-sky"
                        as-child
                    >
                        <a
                            v-if="isExternalHref(item.href)"
                            :href="toUrl(item.href)"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </a>

                        <Link v-else :href="item.href">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>