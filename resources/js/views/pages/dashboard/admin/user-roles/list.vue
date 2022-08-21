<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('User roles') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/admin/user-roles/new"
                    >
                        {{ $t('Create user role') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading"/>
                <div class="bg-white px-4 py-3 flex items-center justify-between border-b border-gray-200 sm:px-6">
                    <div>
                        <label class="sr-only" for="search">{{ $t('Search') }}</label>
                        <div class="flex rounded-md shadow-sm">
                            <div class="relative flex-grow focus-within:z-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.search-regular"></svg-vue>
                                </div>
                                <input
                                    id="search"
                                    v-model.lazy="search"
                                    :placeholder="$t('Search')"
                                    class="form-input block w-full rounded-none rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                    @change="getUserRoles"
                                >
                            </div>
                            <span class="relative inline-flex shadow-sm rounded-r-md">
                                <button
                                    class="relative -ml-px inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700"
                                    type="button"
                                    @click="changeSort"
                                >
                                    <svg-vue
                                        v-show="sort.order === 'asc'"
                                        class="h-5 w-5 text-gray-400"
                                        icon="font-awesome.sort-amount-down-alt-regular"
                                    ></svg-vue>
                                    <svg-vue
                                        v-show="sort.order === 'desc'"
                                        class="h-5 w-5 text-gray-400"
                                        icon="font-awesome.sort-amount-up-alt-regular"
                                    ></svg-vue>
                                    <span class="ml-2">{{ $t('Sort') }}</span>
                                </button>
                                <select
                                    id="sortBy"
                                    v-model="sort.column"
                                    aria-label="Sort by"
                                    class="-ml-px block form-select w-full pl-3 pr-9 py-2 rounded-l-none rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    @change="changeSort"
                                >
                                    <option value="name">{{ $t('Name') }}</option>
                                    <option value="type">{{ $t('Type') }}</option>
                                    <option value="created_at">{{ $t('Created at') }}</option>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
                <template v-if="userRoleList.length > 0">
                    <ul>
                        <template v-for="(userRole, index) in userRoleList">
                            <li :class="{'border-t border-gray-200': index !== 0}">
                                <template v-if="userRole.type === 1">
                                    <div class="block cursor-not-allowed focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        <div class="flex items-center px-4 py-4 sm:px-6">
                                            <div class="min-w-0 flex-1 flex items-center">
                                                <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                                    <div>
                                                        <div class="text-sm leading-5 font-medium text-blue-600 truncate">{{ userRole.name }}</div>
                                                    </div>
                                                    <div class="hidden md:block">
                                                        <div class="text-sm leading-5 text-gray-900">
                                                            <span class="text-cool-gray-900 font-medium">{{ userRole.users }}</span>
                                                            {{ $t('assigned users') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="width: 20px"></div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <router-link
                                        :to="'/dashboard/admin/user-roles/' + userRole.id + '/edit'"
                                        class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                    >
                                        <div class="flex items-center px-4 py-4 sm:px-6">
                                            <div class="min-w-0 flex-1 flex items-center">
                                                <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                                    <div>
                                                        <div class="text-sm leading-5 font-medium text-blue-600 truncate">{{ userRole.name }}</div>
                                                    </div>
                                                    <div class="hidden md:block">
                                                        <div class="text-sm leading-5 text-gray-900">
                                                            <span class="text-cool-gray-900 font-medium">{{ userRole.users }}</span>
                                                            {{ $t('assigned users') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.angle-right-regular"></svg-vue>
                                            </div>
                                        </div>
                                    </router-link>
                                </template>
                            </li>
                        </template>
                    </ul>
                </template>
                <template v-else-if="!loading">
                    <div class="h-full flex">
                        <div class="m-auto">
                            <div class="grid grid-cols-1 justify-items-center h-full w-full px-4 py-10">
                                <div class="flex justify-center items-center">
                                    <svg-vue class="h-full h-auto w-64 mb-12" icon="undraw.browsing"></svg-vue>
                                </div>
                                <div class="flex justify-center items-center">
                                    <div class="w-full font-semibold text-2xl">{{ $t('No records found') }}</div>
                                </div>
                                <template v-if="search">
                                    <div class="flex justify-center items-center">
                                        <div>{{ $t('Try changing the filters, or rephrasing your search') }}</div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="hidden sm:block">
                    <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <p class="text-sm leading-5 text-gray-700">
                            {{ $t('Showing') }}
                            <span class="font-medium">{{ userRoleList.length }}</span>
                            {{ $t('user roles') }}
                        </p>
                    </nav>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "list-user-roles",
    metaInfo() {
        return {
            title: this.$i18n.t('User roles')
        }
    },
    data() {
        return {
            search: '',
            sort: {
                order: 'asc',
                column: 'created_at',
            },
            loading: true,
            userRoleList: [],
        }
    },
    mounted() {
        this.getUserRoles();
    },
    methods: {
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getUserRoles();
        },
        getUserRoles() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/user-roles', {
                params: {
                    sort: self.sort,
                    search: self.search
                }
            }).then(function (response) {
                self.userRoleList = response.data.items;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
    }
}
</script>
