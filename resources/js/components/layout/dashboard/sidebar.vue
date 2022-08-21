<template>
    <div class="flex">
        <div :class="{'': showMenu, 'hidden': !showMenu}" class="md:hidden">
            <div class="fixed inset-0 flex z-40">
                <transition
                    duration="300"
                    enter-active-class="transition-opacity ease-linear duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition-opacity ease-linear duration-300"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        @click="close"
                        class="fixed inset-0"
                        v-show="sidebarVisible"
                    >
                        <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                    </div>
                </transition>
                <transition
                    @after-leave="afterToggleSidebar()"
                    @before-enter="beforeToggleSidebar()"
                    enter-active-class="transition ease-in-out duration-300 transform"
                    enter-class="-translate-x-full"
                    enter-to-class="translate-x-0"
                    leave-active-class="transition ease-in-out duration-300 transform"
                    leave-class="translate-x-0"
                    leave-to-class="-translate-x-full"
                >
                    <div
                        class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800"
                        v-show="sidebarVisible"
                    >
                        <div class="absolute top-0 right-0 -mr-14 p-1">
                            <button
                                @click="close"
                                aria-label="Close sidebar"
                                class="flex items-center justify-center h-12 w-12 rounded-full focus:outline-none focus:bg-gray-600"
                            >
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </svg>
                            </button>
                        </div>
                        <router-link class="flex flex-shrink-0" to="/">
                            <logo></logo>
                        </router-link>
                        <div class="mt-5 flex-1 h-0 overflow-y-auto">
                            <nav>
                                <menu-list mobile></menu-list>
                            </nav>
                        </div>
                    </div>
                </transition>
                <div class="flex-shrink-0 w-14"></div>
            </div>
        </div>
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <router-link class="flex h-16 flex-shrink-0 bg-gray-900" to="/">
                    <logo></logo>
                </router-link>
                <div class="h-0 flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 pb-4 bg-gray-800">
                        <menu-list></menu-list>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Logo from "@/components/layout/shared/logo";
import MenuList from "@/components/layout/dashboard/menu/menu-list";

export default {
    name: "sidebar",
    components: {MenuList, Logo},
    props: {
        sidebarVisible: {
            type: Boolean,
            required: true,
        }
    },
    watch: {
        $route(to, from) {
            this.$emit('toggleSidebar', false);
        }
    },
    data() {
        return {
            showMenu: false
        }
    },
    methods: {
        close() {
            this.$emit('toggleSidebar', false);
        },
        beforeToggleSidebar() {
            this.showMenu = true;
        },
        afterToggleSidebar() {
            this.showMenu = false;
        }
    }
}
</script>
