<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    Archive,
    GitBranch,
    Globe2,
    Home,
    LayoutGrid,
    Menu,
    Newspaper,
    Rocket,
} from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { getInitials } from '@/composables/useInitials';
import { toUrl } from '@/lib/utils';
import { dashboard } from '@/routes';
import type { BreadcrumbItem, NavItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth);
const { isCurrentUrl, whenCurrentUrl } = useCurrentUrl();

const activeItemStyles =
    'bg-accent/10 text-accent dark:bg-accent/20 dark:text-accent';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Datastream',
        href: '/datastream',
        icon: Newspaper,
    },
    {
        title: 'Archives',
        href: '/archives',
        icon: Archive,
    },
    {
        title: 'World',
        href: '/world',
        icon: Globe2,
    },
    {
        title: 'Star Citizen',
        href: '/star-citizen',
        icon: Rocket,
    },
];

const rightNavItems: NavItem[] = [
    {
        title: 'Public Gateway',
        href: '/',
        icon: Home,
    },
    {
        title: 'GitHub',
        href: 'https://github.com/icha-senpai/main',
        icon: GitBranch,
    },
];

const isExternalHref = (href: NavItem['href']) => {
    return (
        typeof href === 'string' &&
        (href.startsWith('http://') || href.startsWith('https://'))
    );
};
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80 bg-sidebar/70 backdrop-blur-xl">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="mr-2 h-9 w-9"
                            >
                                <Menu class="h-5 w-5" />
                            </Button>
                        </SheetTrigger>

                        <SheetContent
                            side="left"
                            class="w-[320px] border-sidebar-border bg-sidebar p-6"
                        >
                            <SheetTitle class="sr-only">
                                DataVerse navigation menu
                            </SheetTitle>

                            <SheetHeader class="flex justify-start text-left">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex size-10 items-center justify-center rounded-xl border border-dv-cyan/30 bg-dv-surface"
                                    >
                                        <AppLogoIcon class="size-7" />
                                    </div>

                                    <div>
                                        <p class="dv-gradient-text text-sm font-black">
                                            The DataVerse
                                        </p>
                                        <p class="text-xs text-sidebar-foreground/60">
                                            Signal Core
                                        </p>
                                    </div>
                                </div>
                            </SheetHeader>

                            <div
                                class="flex h-full flex-1 flex-col justify-between space-y-4 py-6"
                            >
                                <nav class="-mx-3 space-y-1">
                                    <Link
                                        v-for="item in mainNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-sidebar-foreground/80 hover:bg-sidebar-accent hover:text-sidebar-foreground"
                                        :class="
                                            whenCurrentUrl(
                                                item.href,
                                                activeItemStyles,
                                            )
                                        "
                                    >
                                        <component
                                            v-if="item.icon"
                                            :is="item.icon"
                                            class="h-5 w-5"
                                        />
                                        {{ item.title }}
                                    </Link>
                                </nav>

                                <div class="flex flex-col space-y-2">
                                    <template
                                        v-for="item in rightNavItems"
                                        :key="item.title"
                                    >
                                        <a
                                            v-if="isExternalHref(item.href)"
                                            :href="toUrl(item.href)"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-sidebar-foreground/70 hover:bg-sidebar-accent hover:text-sidebar-foreground"
                                        >
                                            <component
                                                v-if="item.icon"
                                                :is="item.icon"
                                                class="h-5 w-5"
                                            />
                                            <span>{{ item.title }}</span>
                                        </a>

                                        <Link
                                            v-else
                                            :href="item.href"
                                            class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium text-sidebar-foreground/70 hover:bg-sidebar-accent hover:text-sidebar-foreground"
                                        >
                                            <component
                                                v-if="item.icon"
                                                :is="item.icon"
                                                class="h-5 w-5"
                                            />
                                            <span>{{ item.title }}</span>
                                        </Link>
                                    </template>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link :href="dashboard()" class="flex items-center gap-x-2">
                    <AppLogo />
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                        <NavigationMenuList
                            class="flex h-full items-stretch space-x-1"
                        >
                            <NavigationMenuItem
                                v-for="(item, index) in mainNavItems"
                                :key="index"
                                class="relative flex h-full items-center"
                            >
                                <Link
                                    :class="[
                                        navigationMenuTriggerStyle(),
                                        whenCurrentUrl(
                                            item.href,
                                            activeItemStyles,
                                        ),
                                        'h-9 cursor-pointer px-3',
                                    ]"
                                    :href="item.href"
                                >
                                    <component
                                        v-if="item.icon"
                                        :is="item.icon"
                                        class="mr-2 h-4 w-4"
                                    />
                                    {{ item.title }}
                                </Link>

                                <div
                                    v-if="isCurrentUrl(item.href)"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-foreground"
                                ></div>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <div class="hidden space-x-1 lg:flex">
                        <template
                            v-for="item in rightNavItems"
                            :key="item.title"
                        >
                            <TooltipProvider :delay-duration="0">
                                <Tooltip>
                                    <TooltipTrigger>
                                        <Button
                                            variant="ghost"
                                            size="icon"
                                            as-child
                                            class="group h-9 w-9 cursor-pointer"
                                        >
                                            <a
                                                v-if="isExternalHref(item.href)"
                                                :href="toUrl(item.href)"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                <span class="sr-only">
                                                    {{ item.title }}
                                                </span>
                                                <component
                                                    :is="item.icon"
                                                    class="size-5 opacity-80 group-hover:opacity-100"
                                                />
                                            </a>

                                            <Link v-else :href="item.href">
                                                <span class="sr-only">
                                                    {{ item.title }}
                                                </span>
                                                <component
                                                    :is="item.icon"
                                                    class="size-5 opacity-80 group-hover:opacity-100"
                                                />
                                            </Link>
                                        </Button>
                                    </TooltipTrigger>

                                    <TooltipContent>
                                        <p>{{ item.title }}</p>
                                    </TooltipContent>
                                </Tooltip>
                            </TooltipProvider>
                        </template>
                    </div>

                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                            >
                                <Avatar
                                    class="size-8 overflow-hidden rounded-full"
                                >
                                    <AvatarImage
                                        v-if="auth.user.avatar"
                                        :src="auth.user.avatar"
                                        :alt="auth.user.name"
                                    />
                                    <AvatarFallback
                                        class="rounded-lg bg-muted font-semibold text-muted-foreground"
                                    >
                                        {{ getInitials(auth.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div
            v-if="props.breadcrumbs.length > 1"
            class="flex w-full border-b border-sidebar-border/70 bg-sidebar/40 backdrop-blur-xl"
        >
            <div
                class="mx-auto flex h-12 w-full items-center justify-start px-4 text-muted-foreground md:max-w-7xl"
            >
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>