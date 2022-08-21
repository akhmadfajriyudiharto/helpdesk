<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Localization') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/admin/settings"
                    >
                        {{ $t('Back') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6">
                <loading :status="loading"/>
                <form @submit.prevent="save">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_timezone">{{ $t('Timezone') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="app_timezone"
                                            v-model="app_timezone"
                                            :placeholder="$t('Timezone')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $t('List of supported timezones can be found') }}
                                        <a class="text-blue-500" href="https://www.php.net/manual/en/timezones.php" target="_blank">{{ $t('here') }}</a>.
                                    </p>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_locale">{{ $t('Site language') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            id="app_locale"
                                            v-model="app_locale"
                                            class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                                            required
                                        >
                                            <option :value="null" disabled>{{ $t('Select an option') }}</option>
                                            <option v-for="language in languages" :value="language.locale">{{ language.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_date_locale">{{ $t('Date locale') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="app_date_locale"
                                            v-model="app_date_locale"
                                            :placeholder="$t('Date locale')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ $t('Set locale used for date and time translation') }}. {{ $t('Selected locale must be installed on the operating system') }}.</p>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_date_format">{{ $t('Date format') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="app_date_format"
                                            v-model="app_date_format"
                                            :placeholder="$t('Date format')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $t('Default format for dates on the site') }}.
                                        {{ $t('List of supported format can be found') }}
                                        <a class="text-blue-500" href="https://momentjs.com/docs/#/displaying/format/" target="_blank">{{ $t('here') }}</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-100 text-right sm:px-6">
                            <div class="inline-flex">
                                <button class="btn btn-green rounded-md shadow-sm" type="submit">
                                    {{ $t('Save settings') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "localization",
    data() {
        return {
            loading: true,
            languages: [],
            app_timezone: null,
            app_locale: null,
            app_date_locale: null,
            app_date_format: null,
        }
    },
    mounted() {
        this.get();
        this.getLanguages();
    },
    methods: {
        getLanguages() {
            const self = this;
            axios.get('api/dashboard/admin/settings/languages').then(function (response) {
                self.languages = response.data;
            });
        },
        get() {
            const self = this;
            axios.get('api/dashboard/admin/settings/localization').then(function (response) {
                self.app_timezone = response.data.app_timezone;
                self.app_locale = response.data.app_locale;
                self.app_date_locale = response.data.app_date_locale;
                self.app_date_format = response.data.app_date_format;
                self.loading = false;
            }).catch(function () {
                this.$router.push('/dashboard/admin/settings');
            });
        },
        save() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/settings/localization', {
                app_timezone: self.app_timezone,
                app_locale: self.app_locale,
                app_date_locale: self.app_date_locale,
                app_date_format: self.app_date_format
            }).then(function () {
                if (document.documentElement.lang !== self.app_locale) {
                    document.documentElement.lang = self.app_locale;
                    self.$i18n.locale = self.app_locale;
                    axios.get('api/lang/' + self.$i18n.locale).then(function (response) {
                        self.$i18n.setLocaleMessage(self.$i18n.locale, response.data);
                    });
                }
                window.app.app_timezone = self.app_timezone;
                window.app.app_date_format = self.app_date_format;
                window.app.app_date_locale = self.app_date_locale;
                self.$store.commit('setSettings', window.app);
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Settings updated successfully').toString(),
                    type: 'success'
                });
            }).catch(function () {
                self.loading = false;
            });
        }
    }
}
</script>
