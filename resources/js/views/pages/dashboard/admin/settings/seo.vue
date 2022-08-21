<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('SEO') }}</h1>
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
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="meta_home_title">{{ $t('Home page title') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="meta_home_title"
                                            v-model="meta_home_title"
                                            :placeholder="$t('Home page title')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ $t('Define the title of the application\' home page to improve SEO positioning') }}.</p>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="meta_keywords">{{ $t('Meta keywords') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="meta_keywords"
                                            v-model="meta_keywords"
                                            :placeholder="$t('Meta keywords')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ $t('Define the keywords of the application to improve SEO positioning') }}.</p>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="meta_description">{{ $t('Meta description') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <textarea
                                            id="meta_description"
                                            v-model="meta_description"
                                            :placeholder="$t('Meta description')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        />
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ $t('Define the description of the application to improve SEO positioning') }}.</p>
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
    name: "seo",
    data() {
        return {
            loading: true,
            meta_home_title: null,
            meta_keywords: null,
            meta_description: null,
        }
    },
    mounted() {
        this.get();
    },
    methods: {
        get() {
            const self = this;
            axios.get('api/dashboard/admin/settings/seo').then(function (response) {
                self.meta_home_title = response.data.meta_home_title;
                self.meta_keywords = response.data.meta_keywords;
                self.meta_description = response.data.meta_description;
                self.loading = false;
            }).catch(function () {
                this.$router.push('/dashboard/admin/settings');
            });
        },
        save() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/settings/seo', {
                meta_home_title: self.meta_home_title,
                meta_keywords: self.meta_keywords,
                meta_description: self.meta_description
            }).then(function () {
                window.app.meta_home_title = self.meta_home_title;
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
