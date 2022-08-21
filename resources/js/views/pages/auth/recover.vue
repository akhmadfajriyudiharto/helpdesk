<template>
    <form @submit.prevent="submit">
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
        <div class="mb-4 text-right">
            <button id="submit-recover" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline" data-style="zoom-in" type="submit">
                {{ $t('Send account recovery email') }}
            </button>
        </div>
        <p class="text-gray-700 text-sm">
            {{ $t('Do you already have access to your account?') }}
            <router-link
                class="align-baseline font-bold text-blue-500 hover:text-blue-800"
                to="/auth/login"
            >
                {{ $t('Sign In') }}
            </router-link>
        </p>
    </form>
</template>

<script>
export default {
    name: "recover",
    metaInfo() {
        return {
            title: this.$i18n.t('Recover account')
        }
    },
    data() {
        return {
            user: {
                email: null,
                captcha: null
            }
        }
    },
    methods: {
        submit() {
            const self = this;
            if (self.$store.state.settings.recaptcha_enabled) {
                self.$recaptcha('recover').then(function (token) {
                    self.user.captcha = token;
                    self.recover();
                });
            } else {
                self.recover();
            }
        },
        recover() {
            const self = this;
            const ladda = Ladda.create(document.querySelector('#submit-recover'));
            ladda.start();
            axios.post('api/auth/recover', this.user).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('An email has been sent with a link to reset the password').toString(),
                    type: 'success'
                })
                self.$router.push('/auth/login');
            }).catch(function () {
                self.user.email = null;
            });
        }
    }
}
</script>
