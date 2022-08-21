<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveUserRole">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Create user role') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Role details') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('This information will be displayed publicly') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Name') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="userRole.name"
                                            :placeholder="$t('Name')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="dashboard_access">{{ $t('Dashboard access') }}</label>
                                    <div class="mt-1 flex rounded-md">
                                        <input-switch
                                            id="dashboard_access"
                                            v-model="userRole.dashboard_access"
                                            :disabled-label="$t('Users will not have access to the dashboard')"
                                            :enabled-label="$t('Users will have access to the dashboard')"
                                        ></input-switch>
                                    </div>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('Users with access to the dashboard will automatically redirect to the start of the dashboard, otherwise, they will not be able to access the dashboard, they will only have access to the helpdesk') }}.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <div class="py-3">
                                <div class="border-t border-gray-200"></div>
                            </div>
                        </div>
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Permissions') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('Sections of the application protected with authentication') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <template v-for="(permissionKey) in permissionKeys">
                                <div class="col-span-3">
                                    <div class="mt-1 flex rounded-md">
                                        <span
                                            id="status"
                                            :class="userRole.permissions.includes(permissionKey) ? 'bg-blue-600' : 'bg-gray-200'"
                                            aria-checked="false"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
                                            role="checkbox"
                                            tabindex="0"
                                            @click="userRole.permissions.includes(permissionKey) ? userRole.permissions.splice(userRole.permissions.indexOf(permissionKey), 1) : userRole.permissions.push(permissionKey)"
                                        >
                                          <span
                                              :class="userRole.permissions.includes(permissionKey) ? 'translate-x-5' : 'translate-x-0'"
                                              aria-hidden="true"
                                              class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
                                          ></span>
                                        </span>
                                        <div class="ml-3 text-gray-800">
                                            {{ permissionLabels[permissionKey] }}
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/user-roles"
                            >
                                {{ $t('Cancel') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Create user role') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </main>
</template>

<script>
export default {
    name: "new-user-role",
    metaInfo() {
        return {
            title: this.$i18n.t('Create user role')
        }
    },
    data() {
        return {
            loading: true,
            permissionKeys: [],
            permissionLabels: [],
            userRole: {
                name: null,
                dashboard_access: false,
                permissions: []
            },
        }
    },
    mounted() {
        this.getPermissions();
    },
    methods: {
        saveUserRole() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/user-roles', self.userRole).then(function (response) {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/user-roles/' + response.data.userRole.id + '/edit');
            }).catch(function () {
                self.loading = false;
            });
        },
        getPermissions() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/user-roles/permissions').then(function (response) {
                self.permissionKeys = response.data.keys;
                self.permissionLabels = response.data.labels;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
    }
}
</script>
