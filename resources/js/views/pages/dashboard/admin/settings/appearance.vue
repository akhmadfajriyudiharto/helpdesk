<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Appearance') }}</h1>
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
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_icon">{{ $t('Icon') }}</label>
                                    <image-input id="app_icon" v-model="app_icon" :remove="false"></image-input>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="app_background">{{ $t('Background') }}</label>
                                    <image-input id="app_background" v-model="app_background" :remove="false"></image-input>
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
    name: "appearance",
    data() {
        return {
            loading: true,
            app_icon: null,
            app_background: null,
        }
    },
    mounted() {
        this.get();
    },
    methods: {
        get() {
            const self = this;
            axios.get('api/dashboard/admin/settings/appearance').then(function (response) {
                self.app_icon = response.data.app_icon;
                self.app_background = response.data.app_background;
                self.loading = false;
            }).catch(function () {
                this.$router.push('/dashboard/admin/settings');
            });
        },
        save() {
            const self = this;
            const formData = new FormData();
            self.loading = true;
            if (self.app_icon.file) {
                formData.append('icon', self.app_icon.file);
            }
            if (self.app_background.file) {
                formData.append('background', self.app_background.file);
            }
            axios.post('api/dashboard/admin/settings/appearance', formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function () {
                self.loading = false;
                if (self.app_icon.file) {
                    self.app_icon.file = null;
                    window.app.icon = self.app_icon.preview;
                    document.querySelector("link[rel*='icon']").href = window.app.icon;
                    self.$store.commit('setSettings', window.app);
                }
                if (self.app_background.file) {
                    self.app_background.file = null;
                    window.app.background = self.app_background.preview;
                    self.$store.commit('setSettings', window.app);
                }
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
