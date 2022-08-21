<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Captcha') }}</h1>
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
                <vue-element-loading :active="loading"/>
                <form @submit.prevent="save">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="recaptcha_enabled">{{ $t('reCaptcha status') }}</label>
                                    <input-switch
                                        id="recaptcha_enabled"
                                        v-model="recaptcha_enabled"
                                        :disabled-label="$t('reCaptcha verification is disabled')"
                                        :enabled-label="$t('reCaptcha verification is enabled')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('Activate the Google reCaptcha v3 verification in public forms, to avoid sending with robots') }}.
                                    </div>
                                </div>
                                <template v-if="recaptcha_enabled">
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="recaptcha_public">{{ $t('reCaptcha public key') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="recaptcha_public"
                                                v-model="recaptcha_public"
                                                :placeholder="$t('reCaptcha public key')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="recaptcha_private">{{ $t('reCaptcha private key') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="recaptcha_private"
                                                v-model="recaptcha_private"
                                                :placeholder="$t('reCaptcha private key')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                type="text"
                                            >
                                        </div>
                                    </div>
                                </template>
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
    name: "captcha",
    metaInfo() {
        return {
            title: this.$i18n.t('Captcha settings')
        }
    },
    data() {
        return {
            loading: true,
            recaptcha_enabled: false,
            recaptcha_private: null,
            recaptcha_public: null,
        }
    },
    mounted() {
        this.get();
    },
    methods: {
        get() {
            const self = this;
            axios.get('api/dashboard/admin/settings/captcha').then(function (response) {
                self.recaptcha_enabled = response.data.recaptcha_enabled;
                self.recaptcha_private = response.data.recaptcha_private;
                self.recaptcha_public = response.data.recaptcha_public;
                self.loading = false;
            }).catch(function () {
                this.$router.push('/dashboard/admin/settings');
            });
        },
        save() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/settings/captcha', {
                recaptcha_enabled: self.recaptcha_enabled,
                recaptcha_private: self.recaptcha_private,
                recaptcha_public: self.recaptcha_public
            }).then(function () {
                self.loading = false;
                window.app.recaptcha_enabled = self.recaptcha_enabled;
                window.app.recaptcha_public = self.recaptcha_public;
                self.$store.commit('setSettings', window.app);
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
