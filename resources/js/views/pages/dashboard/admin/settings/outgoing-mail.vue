<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Outgoing mail') }}</h1>
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
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_from_address">{{ $t('From address') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="mail_from_address"
                                            v-model="mail_from_address"
                                            :placeholder="$t('From address')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('All outgoing application emails will be sent from this email address') }}.
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_from_name">{{ $t('From name') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="mail_from_name"
                                            v-model="mail_from_name"
                                            :placeholder="$t('From name')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('All outgoing application emails will be sent using this name') }}.
                                    </div>
                                </div>
                                <div class="md:col-span-3">
                                    <div class="pt-2 pb-1">
                                        <div class="border-t border-gray-200"></div>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_mailer">{{ $t('Outgoing mail method') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            id="mail_mailer"
                                            v-model="mail_mailer"
                                            class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                                            required
                                        >
                                            <option :value="null" disabled>{{ $t('Select an option') }}</option>
                                            <option value="mailgun">{{ $t('Mailgun') }}</option>
                                            <option value="smtp">{{ $t('SMTP') }}</option>
                                            <option value="sendmail">{{ $t('SendMail') }}</option>
                                            <option value="log">{{ $t('Log (Email will be saved to error log)') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <template v-if="mail_mailer === 'smtp'">
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_host">{{ $t('SMTP Host') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mail_host"
                                                v-model="mail_host"
                                                :placeholder="$t('SMTP Host')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_username">{{ $t('SMTP Username') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mail_username"
                                                v-model="mail_username"
                                                :placeholder="$t('SMTP Host')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_password">{{ $t('SMTP Password') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mail_password"
                                                v-model="mail_password"
                                                :placeholder="$t('SMTP Password')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                type="password"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_port">{{ $t('SMTP Port') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mail_port"
                                                v-model="mail_port"
                                                :placeholder="$t('SMTP Port')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mail_encryption">{{ $t('SMTP Encryption') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mail_encryption"
                                                v-model="mail_encryption"
                                                :placeholder="$t('SMTP Encryption')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                        </div>
                                    </div>
                                </template>
                                <template v-if="mail_mailer === 'mailgun'">
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mailgun_domain">{{ $t('Mailgun domain') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mailgun_domain"
                                                v-model="mailgun_domain"
                                                :placeholder="$t('Mailgun domain')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mailgun_secret">{{ $t('Mailgun secret') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mailgun_secret"
                                                v-model="mailgun_secret"
                                                :placeholder="$t('Mailgun secret')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="mailgun_endpoint">{{ $t('Mailgun endpoint') }}</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input
                                                id="mailgun_endpoint"
                                                v-model="mailgun_endpoint"
                                                :placeholder="$t('Mailgun endpoint')"
                                                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
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
    name: "outgoing-mail",
    data() {
        return {
            loading: true,
            mail_from_address: null,
            mail_from_name: null,
            mail_mailer: null,
            mail_encryption: null,
            mail_host: null,
            mail_password: null,
            mail_port: null,
            mail_username: null,
            mailgun_domain: null,
            mailgun_secret: null,
            mailgun_endpoint: null,
        }
    },
    mounted() {
        this.get();
    },
    methods: {
        get() {
            const self = this;
            axios.get('api/dashboard/admin/settings/outgoing-mail').then(function (response) {
                self.mail_from_address = response.data.mail_from_address;
                self.mail_from_name = response.data.mail_from_name;
                self.mail_mailer = response.data.mail_mailer;
                self.mail_encryption = response.data.mail_encryption;
                self.mail_host = response.data.mail_host;
                self.mail_password = response.data.mail_password;
                self.mail_port = response.data.mail_port;
                self.mail_username = response.data.mail_username;
                self.mailgun_domain = response.data.mailgun_domain;
                self.mailgun_secret = response.data.mailgun_secret;
                self.mailgun_endpoint = response.data.mailgun_endpoint;
                self.loading = false;
            }).catch(function () {
                this.$router.push('/dashboard/admin/settings');
            });
        },
        save() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/settings/outgoing-mail', {
                mail_from_address: self.mail_from_address,
                mail_from_name: self.mail_from_name,
                mail_mailer: self.mail_mailer,
                mail_encryption: self.mail_encryption,
                mail_host: self.mail_host,
                mail_password: self.mail_password,
                mail_port: self.mail_port,
                mail_username: self.mail_username,
                mailgun_domain: self.mailgun_domain,
                mailgun_secret: self.mailgun_secret,
                mailgun_endpoint: self.mailgun_endpoint
            }).then(function () {
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
