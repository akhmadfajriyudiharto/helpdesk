<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Languages') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button
                        id="sync-languages"
                        class="btn btn-secondary shadow-sm rounded-md mr-2"
                        data-style="zoom-in"
                        type="button"
                        @click="syncLanguages"
                    >
                        {{ $t('Synchronize translations') }}
                    </button>
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/admin/languages/new"
                    >
                        {{ $t('Create language') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading"/>
                <template v-if="languagesList.length > 0">
                    <ul>
                        <template v-for="(language, index) in languagesList">
                            <li :class="{'border-t border-gray-200': index !== 0}">
                                <router-link
                                    :to="'/dashboard/admin/languages/' + language.id + '/edit'"
                                    class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                                                <div>
                                                    <div class="text-sm leading-5 font-medium text-blue-600 truncate">{{ language.name }}</div>
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
                <div class="hidden sm:block">
                    <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <p class="text-sm leading-5 text-gray-700">
                            {{ $t('Showing') }}
                            <span class="font-medium">{{ languagesList.length }}</span>
                            {{ $t('languages') }}
                        </p>
                    </nav>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "list-languages",
    metaInfo() {
        return {
            title: this.$i18n.t('Languages')
        }
    },
    data() {
        return {
            loading: true,
            languagesList: [],
        }
    },
    mounted() {
        this.getLanguages();
    },
    methods: {
        getLanguages() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/languages').then(function (response) {
                self.languagesList = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
        syncLanguages() {
            const self = this;
            const ladda = Ladda.create(document.querySelector('#sync-languages'));
            ladda.start();
            self.$notify({
                title: self.$i18n.t('Success').toString(),
                text: self.$i18n.t('The language files synchronization process has been started').toString(),
                type: 'info'
            });
            axios.post('api/dashboard/admin/languages/sync').then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data updated correctly').toString(),
                    type: 'success'
                });
                ladda.stop();
            });
        },
    }
}
</script>
