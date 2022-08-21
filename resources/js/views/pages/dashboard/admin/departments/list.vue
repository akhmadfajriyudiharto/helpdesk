<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Departments') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/admin/departments/new"
                    >
                        {{ $t('Create department') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading"/>
                <template v-if="departmentList.length > 0">
                    <ul>
                        <template v-for="(department, index) in departmentList">
                            <li :class="{'border-t border-gray-200': index !== 0}">
                                <router-link
                                    :to="'/dashboard/admin/departments/' + department.id + '/edit'"
                                    class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                >
                                    <div class="px-4 py-4 flex items-center sm:px-6">
                                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                            <div>
                                                <div class="text-sm font-medium leading-5 text-gray-900 truncate">
                                                    {{ department.name }}
                                                </div>
                                                <div
                                                    v-show="department.public"
                                                    class="mt-2 flex items-center text-sm leading-5 text-gray-500"
                                                >
                                                    <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-green-400" icon="font-awesome.lock-open-alt-solid"></svg-vue>
                                                    {{ $t('The department is public') }}
                                                </div>
                                                <div
                                                    v-show="!department.public"
                                                    class="mt-2 flex items-center text-sm leading-5 text-red-500"
                                                >
                                                    <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-red-400" icon="font-awesome.lock-alt-regular"></svg-vue>
                                                    {{ $t('The department is not public') }}
                                                </div>
                                            </div>
                                            <div class="mt-4 flex-shrink-0 sm:mt-0">
                                                <div class="flex overflow-hidden">
                                                    <template v-if="department.all_agents">
                                                        <div class="text-sm text-gray-700">
                                                            {{ $t('All agents') }}
                                                        </div>
                                                    </template>
                                                    <template v-else-if="department.all_agents && department.agents.length === 0">
                                                        <div class="text-sm text-gray-700">
                                                            {{ $t('No agents assigned') }}
                                                        </div>
                                                    </template>
                                                    <template v-else>
                                                        <template v-for="(agent, index) in department.agents">
                                                            <img
                                                                :class="index !== 0 ? '-ml-1 ' : null"
                                                                :src="agent.avatar === 'gravatar' ? agent.gravatar : agent.avatar"
                                                                :title="agent.name"
                                                                alt="User avatar"
                                                                class="inline-block h-6 w-6 rounded-full text-white shadow-solid"
                                                            />
                                                        </template>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-5 flex-shrink-0">
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
            title: this.$i18n.t('Departments')
        }
    },
    data() {
        return {
            loading: true,
            departmentList: [],
        }
    },
    mounted() {
        this.getDepartments();
    },
    methods: {
        getDepartments() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/departments').then(function (response) {
                self.departmentList = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        }
    }
}
</script>
