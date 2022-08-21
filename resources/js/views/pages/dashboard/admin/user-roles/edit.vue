<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveUserRole">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit user role') }}</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button
                            class="btn btn-red shadow-sm rounded-md"
                            type="button"
                            @click="deleteUserRoleModal = true"
                        >
                            {{ $t('Delete user role') }}
                        </button>
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
                                        <div
                                            :id="'role_' + permissionKey"
                                            :class="userRole.permissions.includes(permissionKey) ? 'bg-blue-600' : 'bg-gray-200'"
                                            aria-checked="false"
                                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
                                            role="checkbox"
                                            tabindex="0"
                                            @click="userRole.permissions.includes(permissionKey) ? userRole.permissions.splice(userRole.permissions.indexOf(permissionKey), 1) : userRole.permissions.push(permissionKey)"
                                        >
                                            <div
                                                :class="userRole.permissions.includes(permissionKey) ? 'translate-x-5' : 'translate-x-0'"
                                                aria-hidden="true"
                                                class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
                                            ></div>
                                        </div>
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
                                {{ $t('Close') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Edit user role') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        <div v-show="deleteUserRoleModal" class="fixed z-20 inset-0 overflow-y-auto">
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
                    <div v-show="deleteUserRoleModal" class="fixed inset-0 transition-opacity">
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
                        v-show="deleteUserRoleModal"
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
                                        {{ $t('Delete user role') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Are you sure you want to delete the user role?') }}
                                            {{ $t('All users with this role will be moved to the default role') }}.
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
                                @click="deleteUserRole"
                            >
                                {{ $t('Delete user role') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="deleteUserRoleModal = false"
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
    name: "edit-user-role",
    metaInfo() {
        return {
            title: this.$i18n.t('Edit user role')
        }
    },
    data() {
        return {
            loading: true,
            deleteUserRoleModal: false,
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
        this.getUserRole();
    },
    methods: {
        saveUserRole() {
            const self = this;
            self.loading = true;
            axios.put('api/dashboard/admin/user-roles/' + self.$route.params.id, self.userRole).then(function () {
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
        getUserRole() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/user-roles/' + self.$route.params.id).then(function (response) {
                self.userRole = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
                self.$router.push('/dashboard/admin/user-roles');
            });
        },
        deleteUserRole() {
            const self = this;
            axios.delete('api/dashboard/admin/user-roles/' + self.$route.params.id).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data deleted successfully').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/user-roles');
            }).catch(function () {
                self.deleteUserRoleModal = false;
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
