<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveLanguage">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit language') }}</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button
                            v-if="language.locale && language.locale !== defaultLocale"
                            class="btn btn-red shadow-sm rounded-md"
                            type="button"
                            @click="deleteLanguageModal = true"
                        >
                            {{ $t('Delete language') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-3">
                        <div class="mt-5 md:mt-0 md:col-span-3">
                            <div class="flex flex-col">
                                <div class="-my-2 -mx-6 overflow-x-auto">
                                    <div class="px-2 align-middle inline-block min-w-full">
                                        <table class="max-w-full divide-y divide-gray-200">
                                            <thead>
                                            <tr>
                                                <th class="px-6 py-3 w-3/6 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ $t('Source text') }}
                                                </th>
                                                <th class="px-6 py-3 w-3/6 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ $t('Translation') }}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <template v-for="translate in translations">
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 w-3/6 text-sm leading-5 font-medium text-gray-900">
                                                        {{ translate.key }}
                                                    </td>
                                                    <td class="px-6 py-4 w-3/6 text-sm leading-5 text-gray-900">
                                                        <textarea-autosize
                                                            v-model="translate.value"
                                                            :class="translate.value !== translate.key ? 'translation-edited' : ''"
                                                            :placeholder="$t('Enter the translated string')"
                                                            class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                            rows="1"
                                                        />
                                                    </td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/languages"
                            >
                                {{ $t('Close') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Edit language') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        <div v-show="deleteLanguageModal" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    duration="300"
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="deleteLanguageModal" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="deleteLanguageModal"
                        aria-labelledby="modal-headline"
                        aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Delete language') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Are you sure you want to delete the language?') }}
                                            {{ $t('All translations will be removed and the application will no longer be available in this language') }}.
                                            {{ $t('This action cannot be undone') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="btn btn-red mr-2 sm:mr-0"
                                type="button"
                                @click="deleteLanguage"
                            >
                                {{ $t('Delete language') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="deleteLanguageModal = false"
                            >
                                {{ $t('Cancel') }}
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "edit-language",
    metaInfo() {
        return {
            title: this.$i18n.t('Edit language')
        }
    },
    data() {
        return {
            loading: true,
            defaultLocale: document.documentElement.lang,
            deleteLanguageModal: false,
            language: {
                name: null,
                locale: null,
            },
            translations: {},
        }
    },
    mounted() {
        this.getLanguage();
    },
    methods: {
        saveLanguage() {
            const self = this;
            self.loading = true;
            axios.put('api/dashboard/admin/languages/' + self.$route.params.id, {strings: self.translations}).then(function () {
                if (self.language.locale === self.defaultLocale) {
                    axios.get('api/lang/' + self.$i18n.locale).then(function (response) {
                        self.$i18n.setLocaleMessage(self.$i18n.locale, response.data);
                    });
                }
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data updated correctly').toString(),
                    type: 'success'
                });
            }).catch(function () {
                self.loading = false;
            });
        },
        getLanguage() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/languages/' + self.$route.params.id).then(function (response) {
                self.language = response.data.language;
                self.translations = response.data.translations;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
                self.$router.push('/dashboard/admin/languages');
            });
        },
        deleteLanguage() {
            const self = this;
            axios.delete('api/dashboard/admin/languages/' + self.$route.params.id).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data deleted successfully').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/languages');
            }).catch(function () {
                self.deleteLanguageModal = false;
            });
        },
    }
}
</script>
