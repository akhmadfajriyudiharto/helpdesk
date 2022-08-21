<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Settings') }}</h1>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6">
                <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/general">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.keyboard-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('General') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure general site settings') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/seo">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.search-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('SEO') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure site SEO parameters') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/appearance">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.swatchbook-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('Appearance') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure the site icon and background') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/localization">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.language-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('Localization') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure localization settings for the site') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/authentication">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.fingerprint-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('Authentication') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure registration, social login and related 3rd party integrations') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/outgoing-mail">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.inbox-out-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('Outgoing mail') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure outgoing email service preferences') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/logging">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.exclamation-triangle-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('Logging') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure outgoing email service preferences') }}</p>
                        </div>
                    </router-link>
                    <router-link class="col-span-1 flex flex-col text-center cursor-pointer bg-white rounded-lg shadow" tag="li" to="/dashboard/admin/settings/captcha">
                        <div class="flex-1 flex flex-col p-8">
                            <div class="flex-shrink-0 mx-auto bg-gray-700 rounded-3xl">
                                <svg-vue class="w-16 h-16 p-3 text-gray-200" icon="font-awesome.robot-duotone"></svg-vue>
                            </div>
                            <h3 class="mt-6 text-gray-900 text-xl leading-5 font-medium">{{ $t('Captcha') }}</h3>
                            <p class="text-gray-500 text-sm leading-5 mt-2">{{ $t('Configure captcha settings & preferences') }}</p>
                        </div>
                    </router-link>
                </ul>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "index"
}
</script>
