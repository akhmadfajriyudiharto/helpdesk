<template>
    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="py-0.5 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                            {{ $t('My tickets') }}
                        </h2>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <router-link
                            class="btn btn-blue shadow-sm rounded-md"
                            to="/tickets/new"
                        >
                            {{ $t('New ticket') }}
                        </router-link>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-10 my-6 bg-white shadow overflow-hidden sm:rounded-md">
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
                                        class="form-input block border-gray-300 w-full rounded-none rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                        @change="getTickets"
                                    >
                                </div>
                                <div class="relative inline-flex rounded-none">
                                    <select
                                        id="status"
                                        v-model="filters.status"
                                        aria-label="Sort by"
                                        class="-mx-px block form-select w-full pl-3 pr-9 py-2 rounded-none border border-r-0 border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                        @change="getTickets"
                                    >
                                        <option :value="null">{{ $t('All requests') }}</option>
                                        <template v-for="status in statusList">
                                            <option :value="status.id">{{ status.name }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="relative inline-flex rounded-r-md">
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
                                        <option value="subject">{{ $t('Subject') }}</option>
                                        <option value="status_id">{{ $t('Status') }}</option>
                                        <option value="created_at">{{ $t('Created at') }}</option>
                                        <option value="updated_at">{{ $t('Updated at') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-if="ticketList.length > 0">
                        <div class="-my-2 sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <table class="min-w-full  divide-y divide-gray-200">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                            {{ $t('Subject') }}
                                        </th>
                                        <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                            {{ $t('Created at') }}
                                        </th>
                                        <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                            {{ $t('Updated at') }}
                                        </th>
                                        <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                            {{ $t('Status') }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                    <template v-for="ticket in ticketList">
                                        <router-link
                                            :to="'/tickets/' + ticket.uuid"
                                            class="cursor-pointer hover:bg-gray-100 p"
                                            tag="tr"
                                        >
                                            <td class="px-6 py-4 max-w-0 w-full whitespace-no-wrap">
                                                <div class="w-full truncate text-sm leading-5 text-gray-900">
                                                    {{ ticket.subject }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap leading-5">
                                                <div class="text-sm text-gray-800">
                                                    {{ ticket.created_at | momentFormatDate }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap leading-5">
                                                <div class="text-sm text-gray-800">
                                                    {{ ticket.updated_at | momentFormatDateTimeAgo }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-no-wrap leading-5">
                                                <div class="text-sm text-gray-800">
                                                    {{ ticket.status.name }}
                                                </div>
                                            </td>
                                        </router-link>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>
                    <template v-else-if="!loading">
                        <div class="h-full flex">
                            <div class="m-auto">
                                <div class="grid grid-cols-1 justify-items-center h-full w-full py-24">
                                    <div class="flex justify-center items-center">
                                        <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <div class="w-full font-semibold text-2xl">{{ $t('No records found') }}</div>
                                    </div>
                                    <template v-if="anyFilter">
                                        <div class="flex justify-center items-center">
                                            <div>{{ $t('Try changing the filters, or rephrasing your search') }}.</div>
                                        </div>
                                    </template>
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
    </div>
</template>

<script>
export default {
    name: "index",
    metaInfo() {
        return {
            title: this.$i18n.t('My tickets')
        }
    },
    mounted() {
        this.getStatuses();
        this.getTickets();
    },
    data() {
        return {
            loading: true,
            ticketList: [],
            statusList: [],
            filters: {
                search: '',
                status: null,
            },
            sort: {
                order: 'desc',
                column: 'updated_at',
            },
            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
        };
    },
    computed: {
        anyFilter() {
            return this.filters.search !== ''
                || this.filters.status !== null
        }
    },
    filters: {
        momentFormatDate: function (value) {
            return moment(value).locale(window.app.app_date_locale).format(window.app.app_date_format);
        },
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    methods: {
        getStatuses() {
            const self = this;
            axios.get('api/tickets/statuses').then(function (response) {
                self.statusList = response.data;
            });
        },
        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getTickets();
            }
        },
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getTickets();
        },
        getTickets() {
            const self = this;
            self.loading = true;
            axios.get('api/tickets', {
                params: {
                    page: self.page,
                    sort: self.sort,
                    perPage: self.perPage,
                    search: self.filters.search,
                    status: self.filters.status,
                }
            }).then(function (response) {
                self.ticketList = response.data.items;
                self.pagination = response.data.pagination;
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getTickets();
                } else {
                    self.loading = false;
                }
            }).catch(function () {
                self.loading = false;
            });
        },
    }
}
</script>
