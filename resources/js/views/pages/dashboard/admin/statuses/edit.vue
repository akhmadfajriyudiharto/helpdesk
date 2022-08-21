<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveStatus">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit status') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Status details') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('Status details and customization') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Name') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="status.name"
                                            :placeholder="$t('Name')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/statuses"
                            >
                                {{ $t('Close') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Edit status') }}
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
    name: "edit",

    metaInfo() {
        return {
            title: this.$i18n.t('Edit status')
        }
    },
    data() {
        return {
            loading: true,
            deleteStatusModal: false,
            status: {
                name: null,
            },
        }
    },
    mounted() {
        this.getStatus();
    },
    methods: {
        saveStatus() {
            const self = this;
            self.loading = true;
            axios.put('api/dashboard/admin/statuses/' + self.$route.params.id, self.status).then(function () {
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
        getStatus() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/statuses/' + self.$route.params.id).then(function (response) {
                self.status = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
    }
}
</script>
