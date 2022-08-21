<template>
    <form @submit.prevent="submit">
        <div class="mb-4 relative rounded-md shadow-sm">
            <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Name') }}</label>
            <input
                id="name"
                v-model="user.name"
                :placeholder="$t('Name')"
                class="form-input block w-full mt-1 sm:text-sm sm:leading-5"
                required
            />
        </div>
        <div class="mb-4 relative rounded-md shadow-sm">
            <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{ $t('Email') }}</label>
            <input
                id="email"
                v-model="user.email"
                :placeholder="$t('Email')"
                class="form-input block w-full mt-1 sm:text-sm sm:leading-5"
                required
                type="text"
            />
        </div>
        <div class="mb-4 relative rounded-md shadow-sm">
            <label class="block text-sm font-medium leading-5 text-gray-700" for="password">{{ $t('Password') }}</label>
            <input
                id="password"
                v-model="user.password"
                class="form-input block w-full mt-1 sm:text-sm sm:leading-5"
                placeholder="******************"
                required
                type="password"
            />
        </div>
        <div class="mb-4 relative rounded-md shadow-sm">
            <label class="block text-sm font-medium leading-5 text-gray-700" for="password_confirmation">{{ $t('Confirm password') }}</label>
            <input
                id="password_confirmation"
                v-model="user.password_confirmation"
                class="form-input block w-full mt-1 sm:text-sm sm:leading-5"
                placeholder="******************"
                required
                type="password"
            />
        </div>
        <div class="mb-4 text-right">
            <button id="submit-register" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline" data-style="zoom-in" type="submit">
                {{ $t('Create account') }}
            </button>
        </div>
        <p class="text-gray-700 text-sm">
            {{ $t('Do you already have an account?') }}
            <router-link class="align-baseline font-bold text-blue-500 hover:text-blue-800" to="/auth/login">
                {{ $t('Sign In') }}
            </router-link>
        </p>
    </form>
</template>

<script>
export default {
    name: "register",
    metaInfo() {
        return {
            title: this.$i18n.t('Register')
        }
    },
    data() {
        return {
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
                captcha: null
            }
        }
    },
    methods: {
        submit() {
            const self = this;
            if (self.$store.state.settings.recaptcha_enabled) {
                self.$recaptcha('register').then(function (token) {
                    self.user.captcha = token;
                    self.register();
                });
            } else {
                self.register();
            }
        },
        register() {
            const self = this;
            const ladda = Ladda.create(document.querySelector('#submit-register'));
            ladda.start();
            axios.post('api/auth/register', this.user).then(function (response) {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Account created successfully').toString(),
                    type: 'success'
                })
                self.$store.commit('login', response.data);
                if (response.data.user.role.dashboard_access) {
                    self.$router.push('/dashboard/home');
                } else {
                    self.$router.push('/tickets/list');
                }
            }).catch(function () {
                self.user.password = null;
                self.user.password_confirmation = null;
            });
        }
    }
}
</script>
