<template>
    <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
        <button aria-label="Open sidebar" class="px-4 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden" @click="$emit('toggleSidebar')">
            <svg-vue class="h-6 w-6" icon="font-awesome.bars-regular"></svg-vue>
        </button>
        <div class="w-full px-4 flex justify-end">
            <div class="flex">
                <div class="ml-4 flex-1 flex items-center md:ml-6">
                    <!--<button class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500" aria-label="Notifications">-->
                    <!--    <svg-vue class="h-6 w-6 p-px" icon="font-awesome.bell-regular"></svg-vue>-->
                    <!--</button>-->
                    <div v-on-clickaway="closeDropdown" class="ml-3 relative">
                        <button
                            id="user-menu"
                            aria-haspopup="true"
                            aria-label="User menu"
                            class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline"
                            @click="dropdownOpen = !dropdownOpen"
                        >
                            <img
                                :src="$store.state.user.avatar === 'gravatar' ? $store.state.user.gravatar : $store.state.user.avatar"
                                alt="User avatar"
                                class="h-8 w-8 rounded-full"
                            />
                        </button>
                        <transition
                            duration="100"
                            enter-active-class="transition ease-out duration-100"
                            enter-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <div v-show="dropdownOpen" class="origin-top-right z-10 absolute right-0 mt-2 w-56 rounded-md shadow-lg">
                                <div aria-labelledby="user-menu" aria-orientation="vertical" class="py-1 rounded-md bg-white shadow-xs" role="menu">
                                    <div class="flex items-center px-4 ce py-2 border-b border-gray-100">
                                        <img
                                            :src="$store.state.user.avatar === 'gravatar' ? $store.state.user.gravatar : $store.state.user.avatar"
                                            alt="User avatar"
                                            class="h-8 w-8 mr-3 align-middle rounded-full"
                                        />
                                        <div class="w-40">
                                            <div class="text-sm font-medium truncate text-gray-800">{{ $store.state.user.name }}</div>
                                            <div class="text-xs truncate text-gray-500">{{ $store.state.user.email }}</div>
                                        </div>
                                    </div>
                                    <router-link
                                        v-if="$store.state.user ? $store.state.user.role.dashboard_access : false"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                                        role="menuitem"
                                        to="/dashboard/home"
                                        @click.native="dropdownOpen = false"
                                    >
                                        {{ $t('Dashboard') }}
                                    </router-link>
                                    <router-link
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                                        role="menuitem"
                                        to="/tickets/list"
                                        @click.native="dropdownOpen = false"
                                    >
                                        {{ $t('My tickets') }}
                                    </router-link>
                                    <router-link
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                                        role="menuitem"
                                        to="/account"
                                        @click.native="dropdownOpen = false"
                                    >
                                        {{ $t('Account settings') }}
                                    </router-link>
                                    <a
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                                        href="/auth/logout"
                                        role="menuitem"
                                        @click.prevent="signOut"
                                    >
                                        {{ $t('Sign out') }}
                                    </a>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default {
    name: "navbar",
    mixins: [clickaway],
    data() {
        return {
            dropdownOpen: false
        }
    },
    methods: {
        signOut() {
            this.dropdownOpen = false;
            this.$store.commit('logout');
            this.$router.push('/auth/login');
        },
        closeDropdown() {
            this.dropdownOpen = false;
        }
    }
}
</script>
