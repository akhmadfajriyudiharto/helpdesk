<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Authentication') }}</h1>
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
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_user_registration">{{ $t('User registration') }}</label>
                                    <input-switch
                                        id="app_user_registration"
                                        v-model="app_user_registration"
                                        :disabled-label="$t('User registration is disabled')"
                                        :enabled-label="$t('User registration is enabled')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('Allow users to register their account directly from the authentication page') }}.
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_default_role">{{ $t('Default role') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            id="app_default_role"
                                            v-model="app_default_role"
                                            class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
                                            required
                                        >
                                            <option :value="null" disabled>{{ $t('Select an option') }}</option>
                                            <option v-for="userRole in userRoles" :value="userRole.id">{{ userRole.name }}</option>
                                        </select>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ $t('Role that is assigned to a user on the registration page') }}.</p>
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
    name: "authentication",
    data() {
        return {
            loading: true,
            userRoles: [],
            app_user_registration: null,
            app_default_role: null,
        }
    },
    mounted() {
        this.get();
        this.getUserRoles();
    },
    methods: {
        getUserRoles() {
            const self = this;
            axios.get('api/dashboard/admin/settings/user-roles').then(function (response) {
                self.userRoles = response.data;
            });
        },
        get() {
            const self = this;
            axios.get('api/dashboard/admin/settings/authentication').then(function (response) {
                self.app_user_registration = response.data.app_user_registration;
                self.app_default_role = response.data.app_default_role;
                self.loading = false;
            }).catch(function () {
                this.$router.push('/dashboard/admin/settings');
            });
        },
        save() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/settings/authentication', {
                app_user_registration: self.app_user_registration,
                app_default_role: self.app_default_role
            }).then(function () {
                window.app.register = self.app_user_registration;
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
