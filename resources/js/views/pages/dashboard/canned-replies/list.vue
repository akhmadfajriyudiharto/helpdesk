<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Canned replies') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/canned-replies/new"
                    >
                        {{ $t('Create canned reply') }}
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
                                    v-model.lazy="filters.search"
                                    :placeholder="$t('Search')"
                                    class="form-input block w-full rounded-none rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                    @change="getCannedReplies"
                                >
                            </div>
                            <div class="relative inline-flex shadow-sm rounded-r-md">
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
                                    id="sort.column"
                                    v-model="sort.column"
                                    aria-label="Sort by"
                                    class="-ml-px block form-select w-full pl-3 pr-9 py-2 rounded-l-none rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    @change="changeSort"
                                >
                                    <option value="name">{{ $t('Name') }}</option>
                                    <option value="shared">{{ $t('Shared') }}</option>
                                    <option value="user_id">{{ $t('User') }}</option>
                                    <option value="created_at">{{ $t('Created at') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if="cannedReplyList.length > 0">
                    <ul>
                        <template v-for="(cannedReply, index) in cannedReplyList">
                            <li :class="{'border-t border-gray-200': index !== 0}">
                                <router-link
                                    :to="'/dashboard/canned-replies/' + cannedReply.id + '/edit'"
                                    class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="min-w-0 flex-1 r-4 lg:grid lg:grid-cols-2 lg:gap-4">
                                                <div>
                                                    <div class="text-sm font-medium leading-5 text-gray-800 truncate">{{ cannedReply.name }}</div>
                                                    <div
                                                        v-show="cannedReply.shared"
                                                        class="mt-2 flex items-center text-sm leading-5 text-gray-500"
                                                    >
                                                        <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-green-400" icon="font-awesome.share-alt-solid"></svg-vue>
                                                        {{ $t('The canned reply is shared') }}
                                                    </div>
                                                    <div
                                                        v-show="!cannedReply.shared"
                                                        class="mt-2 flex items-center text-sm leading-5 text-red-500"
                                                    >
                                                        <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-red-400" icon="font-awesome.share-alt-solid"></svg-vue>
                                                        {{ $t('The canned reply is not shared') }}
                                                    </div>
                                                </div>
                                                <div class="hidden lg:block">
                                                    <div class="flex justify-start">
                                                        <div class="flex-none">
                                                            <img :alt="$t('Avatar')" :src="cannedReply.user.avatar !== 'gravatar' ? cannedReply.user.avatar : cannedReply.user.gravatar" class="h-10 w-10 rounded-full">
                                                        </div>
                                                        <div class="mx-4">
                                                            <div class="text-sm font-medium text-gray-800 truncate">{{ cannedReply.user.name }}</div>
                                                            <div class="text-sm text-gray-500 truncate">{{ cannedReply.user.email }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.angle-right-regular"></svg-vue>
                                        </div>
                                    </div>
                                </router-link>
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
                            </div>
                        </div>
                    </div>
                </template>
                <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="hidden sm:block">
                        <p class="text-sm leading-5 text-gray-700">
                            {{ $t('Showing') }}
                            <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                            {{ $t('to') }}
                            <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                            {{ $t('of') }}
                            <span class="font-medium">{{ pagination.total }}</span>
                            {{ $t('results') }}
                        </p>
                    </div>
                    <div class="flex-1 flex justify-between sm:justify-end">
                        <button
                            :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                            :disabled="pagination.currentPage <= 1"
                            class="pagination-link"
                            type="button"
                            @click="changePage(pagination.currentPage - 1)"
                        >
                            {{ $t('Previous') }}
                        </button>
                        <button
                            :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                            :disabled="pagination.currentPage >= pagination.totalPages"
                            class="ml-3 pagination-link"
                            type="button"
                            @click="changePage(pagination.currentPage + 1)"
                        >
                            {{ $t('Next') }}
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('Canned replies')
        }
    },
    data() {
        return {
            page: 1,
            filters: {
                search: null,
            },
            sort: {
                order: 'asc',
                column: 'created_at',
            },
            perPage: 10,
            loading: true,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            cannedReplyList: [],
        }
    },
    mounted() {
        this.getCannedReplies();
    },
    methods: {
        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getCannedReplies();
            }
        },
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getCannedReplies();
        },
        getCannedReplies() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/canned-replies', {
                params: {
                    page: self.page,
                    sort: self.sort,
                    perPage: self.perPage,
                    search: self.filters.search
                }
            }).then(function (response) {
                self.cannedReplyList = response.data.items;
                self.pagination = response.data.pagination;
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getCannedReplies();
                } else {
                    self.loading = false;
                }
            }).catch(function () {
                self.loading = false;
            });
        }
    }
}
</script>
