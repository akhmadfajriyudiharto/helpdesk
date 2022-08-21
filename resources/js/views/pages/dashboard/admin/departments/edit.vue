<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveDepartment">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit department') }}</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button
                            class="btn btn-red shadow-sm rounded-md"
                            type="button"
                            @click="deleteDepartmentModal = true"
                        >
                            {{ $t('Delete department') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Department details') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('Department details and settings') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Name') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="department.name"
                                            :placeholder="$t('Name')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="all_agents">{{ $t('All agents') }}</label>
                                    <input-switch
                                        id="all_agents"
                                        v-model="department.all_agents"
                                        :disabled-label="$t('Only selected agents')"
                                        :enabled-label="$t('All agents')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('Allows access to the department to all agents, or exclusively to a specific group of agents') }}.
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="public">{{ $t('Visibility') }}</label>
                                    <input-switch
                                        id="public"
                                        v-model="department.public"
                                        :disabled-label="$t('The department is private')"
                                        :enabled-label="$t('The department is public')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('If the department is public, it allows users to select this department when creating the ticket, otherwise only agents can reassign to this department') }}.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template v-if="!department.all_agents">
                            <div class="md:col-span-3">
                                <div class="py-3">
                                    <div class="border-t border-gray-200"></div>
                                </div>
                            </div>
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Department agents') }}</h3>
                                <p class="mt-1 text-sm leading-5 text-gray-500">
                                    {{ $t('List of agents assigned to the department') }}.
                                </p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <div class="grid grid-cols-3 gap-6">
                                    <div class="col-span-3">
                                        <div :style="{maxHeight: '200px'}" class="flex flex-col overflow-y-auto">
                                            <template v-for="user in users">
                                                <div class="flex items-center px-6 py-3 hover:bg-gray-100 cursor-pointer rounded" @click="selectAgent(user.id)">
                                                    <div>
                                                        <div class="flex items-center justify-center">
                                                            <svg-vue v-if="department.agents.includes(user.id)" class="w-5 h-5 text-green-400" icon="font-awesome.check-circle-solid"></svg-vue>
                                                            <div v-else class="w-5 h-5 p-1 overflow-hidden rounded-full border"></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col ml-6">
                                                        <p class="text-sm leading-5 text-gray-700 group-hover:text-gray-900">{{ user.name }}</p>
                                                        <p class="text-xs leading-4 text-gray-500 group-hover:text-gray-700 group-focus:underline transition ease-in-out duration-150">{{ user.email }}</p>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <img
                                                            :src="user.avatar === 'gravatar' ? user.gravatar : user.avatar"
                                                            alt="User avatar"
                                                            class="inline-block rounded-full h-8 w-8"
                                                        />
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/departments"
                            >
                                {{ $t('Close') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Edit department') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        <div v-show="deleteDepartmentModal" class="fixed z-20 inset-0 overflow-y-auto">
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
                    <div v-show="deleteDepartmentModal" class="fixed inset-0 transition-opacity">
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
                        v-show="deleteDepartmentModal"
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
                                        {{ $t('Delete department') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Are you sure you want to delete the department?') }}
                                            {{ $t('All data will be permanently removed') }}.
                                            {{ $t('Tickets with this department will be changed to "Without department"') }}.
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
                                @click="deleteDepartment"
                            >
                                {{ $t('Delete department') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="deleteDepartmentModal = false"
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
    name: "edit",
    metaInfo() {
        return {
            title: this.$i18n.t('Edit department')
        }
    },
    data() {
        return {
            loading: true,
            deleteDepartmentModal: false,
            users: [],
            department: {
                name: null,
                all_agents: false,
                public: true,
                agents: [],
            },
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        saveDepartment() {
            const self = this;
            self.loading = true;
            axios.put('api/dashboard/admin/departments/' + self.$route.params.id, self.department).then(function (response) {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data updated correctly').toString(),
                    type: 'success'
                });
                self.department = response.data.department;
            }).catch(function () {
                self.loading = false;
            });
        },
        getUsers() {
            const self = this;
            axios.get('api/dashboard/admin/departments/users').then(function (response) {
                self.users = response.data;
                self.getDepartment();
            }).catch(function () {
                self.loading = false;
            });
        },
        getDepartment() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/departments/' + self.$route.params.id).then(function (response) {
                self.department = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
        deleteDepartment() {
            const self = this;
            axios.delete('api/dashboard/admin/departments/' + self.$route.params.id).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data deleted successfully').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/departments');
            }).catch(function () {
                self.deleteLabelModal = false;
            });
        },
        selectAgent(user) {
            if (this.department.agents.includes(user)) {
                for (let i = 0; i < this.department.agents.length; i++) {
                    if (this.department.agents[i] === user) {
                        this.department.agents.splice(i, 1);
                    }
                }
            } else {
                this.department.agents.push(user);
            }
        }
    }
}
</script>
