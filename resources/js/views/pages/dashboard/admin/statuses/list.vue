<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Statuses') }}</h1>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading"/>
                <template v-if="statusList.length > 0">
                    <ul>
                        <template v-for="(status, index) in statusList">
                            <li :class="{'border-t border-gray-200': index !== 0}">
                                <router-link
                                    :to="'/dashboard/admin/statuses/' + status.id + '/edit'"
                                    class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="min-w-0 flex-1 pr-4 lg:grid lg:grid-cols-2 lg:gap-4">
                                                <div class="flex">
                                                    <div class="inline-block align-middle text-sm font-medium leading-5 text-gray-900">{{ status.name }}</div>
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
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('Statuses')
        }
    },
    data() {
        return {
            loading: true,
            statusList: [],
        }
    },
    mounted() {
        this.getStatuses();
    },
    methods: {
        getStatuses() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/statuses').then(function (response) {
                self.statusList = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        }
    }
}
</script>
