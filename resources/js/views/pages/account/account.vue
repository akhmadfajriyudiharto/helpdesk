<template>
    <div class="min-h-screen bg-gray-100">
        <navbar/>
        <div class="py-10">
            <header>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="py-0.5 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                                {{ $t('Account settings') }}
                            </h2>
                        </div>
                    </div>
                </div>
            </header>
            <main>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="mt-10 shadow sm:rounded-lg">
                        <form @submit.prevent="editUser">
                            <loading :status="loading.details"/>
                            <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Personal information') }}</h3>
                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        {{ $t('This information will be displayed publicly so be careful what you share') }}.
                                    </p>
                                </div>
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Name') }}</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <input id="name" v-model="user.name" :placeholder="$t('Your name')" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 grid grid-cols-3 gap-6">
                                        <div class="col-span-3">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{ $t('Email') }}</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <input id="email" v-model="user.email" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="email@email.com" type="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <label class="block text-sm leading-5 font-medium text-gray-700">{{ $t('Avatar') }}</label>
                                        <div class="mt-2 flex items-center select-none">
                                            <div class="avatar-editor relative inline-block h-12 w-12 overflow-hidden bg-gray-100">
                                                <button
                                                    v-show="user.avatar !== 'gravatar'"
                                                    class="avatar-editor-remove absolute top-0 right-0 items-center p-0.5 rounded-full leading-4 bg-red-600 text-white cursor-pointer"
                                                    type="button"
                                                    @click="removeAvatar"
                                                >
                                                    <svg-vue class="h-4 w-4 p-px" icon="font-awesome.times-light"></svg-vue>
                                                </button>
                                                <img
                                                    :src="user.avatar === 'gravatar' ? user.gravatar : user.avatar_preview"
                                                    alt="User avatar"
                                                    class="h-full w-full text-gray-300 rounded-full"
                                                />
                                            </div>
                                            <span class="ml-5 rounded-md shadow-sm">
                                                <input ref="changeAvatar" accept=".png,.jpg,.jpeg" hidden type="file" @change="changeAvatar($event)">
                                                <button
                                                    class="py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"
                                                    type="button"
                                                    @click="selectAvatar"
                                                >
                                                    {{ $t('Change') }}
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                                <span class="inline-flex">
                                    <button class="btn btn-blue rounded-md shadow-sm" type="submit">
                                        {{ $t('Save') }}
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="mt-10 shadow sm:rounded-lg">
                        <form @submit.prevent="changePassword">
                            <loading :status="loading.password"/>
                            <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                                <div class="md:col-span-1">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Change password') }}</h3>
                                    <p class="mt-1 text-sm leading-5 text-gray-500">
                                        {{ $t('Change your password for a new one, valid for the next login') }}.
                                    </p>
                                </div>
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="current_password">{{ $t('Current password') }}</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <input
                                                    id="current_password"
                                                    v-model="user.current_password"
                                                    :placeholder="$t('Your current password')"
                                                    class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                    type="password"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 grid grid-cols-3 gap-6">
                                        <div class="col-span-3">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="password">{{ $t('New password') }}</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <input
                                                    id="password"
                                                    v-model="user.password"
                                                    :placeholder="$t('Your new password')"
                                                    class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                    type="password"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 grid grid-cols-3 gap-6">
                                        <div class="col-span-3">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="password_confirmation">{{ $t('Current password') }}</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <input
                                                    id="password_confirmation"
                                                    v-model="user.password_confirmation"
                                                    :placeholder="$t('Confirm your new password')"
                                                    class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                    type="password"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                                <span class="inline-flex">
                                    <button class="btn btn-blue rounded-md shadow-sm" type="submit">
                                        {{ $t('Change password') }}
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import Navbar from "@/components/layout/shared/navbar";

export default {
    name: "Account",
    metaInfo() {
        return {
            title: this.$i18n.t('Account')
        }
    },
    components: {Navbar},
    mounted() {
        this.getUser();
    },
    data() {
        return {
            loading: {
                details: true,
                password: false,
            },
            user: {
                name: null,
                avatar: null,
                gravatar: null,
                avatar_preview: null,
                email: null,
                current_password: null,
                password: null,
                password_confirmation: null,
            },
        }
    },
    methods: {
        getUser() {
            const self = this;
            self.loading.details = true;
            axios.get('api/auth/user').then(function (response) {
                self.loading.details = false;
                self.user.name = response.data.name;
                self.user.email = response.data.email;
                self.user.avatar = response.data.avatar;
                self.user.gravatar = response.data.gravatar;
                self.user.avatar_preview = response.data.avatar;
            }).catch(function () {
                self.loading.details = false;
            });
        },
        selectAvatar() {
            this.$refs.changeAvatar.click();
        },
        removeAvatar() {
            this.user.avatar = 'gravatar';
            this.user.avatar_preview = null;
            this.$refs.changeAvatar.value = '';
        },
        changeAvatar(event) {
            const self = this;
            if (event.target.files.length) {
                if (['image/png', 'mage/x-citrix-png', 'image/x-png', 'image/jpeg', 'image/x-citrix-jpeg'].includes(event.target.files[0].type)) {
                    self.user.avatar = event.target.files[0];
                    self.user.avatar_preview = URL.createObjectURL(event.target.files[0]);
                } else {
                    self.$notify({
                        title: self.$i18n.t('Unsupported file type').toString(),
                        text: self.$i18n.t('Only image type files are accepted').toString(),
                        type: 'error'
                    })
                }
            }
        },
        editUser() {
            const self = this;
            const formData = new FormData();
            self.loading.details = true;
            formData.append('name', self.user.name);
            formData.append('email', self.user.email);
            if (self.user.avatar === 'gravatar') {
                formData.append('gravatar', 'true');
            } else if (self.user.avatar instanceof File) {
                formData.append('avatar', self.user.avatar);
            }
            axios.post('api/account/update', formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (response) {
                self.loading.details = false;
                self.user.avatar = response.data.avatar;
                self.user.gravatar = response.data.gravatar;
                self.user.avatar_preview = response.data.avatar;
                self.$refs.changeAvatar.value = '';
                self.$store.commit('updateUser', response.data);
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Your account details have been updated').toString(),
                    type: 'success'
                })
            }).catch(function () {
                self.loading.details = false;
            });
        },
        changePassword() {
            const self = this;
            self.loading.password = true;
            axios.post('api/account/password', {
                current_password: self.user.current_password,
                password: self.user.password,
                password_confirmation: self.user.password_confirmation,
            }).then(function () {
                self.loading.password = false;
                self.user.current_password = null;
                self.user.password = null;
                self.user.password_confirmation = null;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Password changed successfully').toString(),
                    type: 'success'
                })
            }).catch(function () {
                self.loading.password = false;
            });
        }
    }
}
</script>

<style lang="scss">
.avatar-editor {
    .avatar-editor-remove {
        @apply hidden;
    }

    &:hover {
        .avatar-editor-remove {
            @apply inline-flex;
        }
    }
}
</style>
