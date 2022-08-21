<template>
    <div class="min-h-screen bg-gray-100">
        <navbar/>
        <main class="flex-1 relative overflow-y-auto py-24 focus:outline-none" tabindex="0">
            <div class="h-full flex">
                <div class="m-auto">
                    <div class="h-full w-full text-center items-center p-6">
                        <svg-vue class="h-full md:h-64 mb-6" icon="undraw.page-not-found"></svg-vue>
                        <div class="font-semibold text-2xl">{{ $t('Whoops! Looks like you got lost') }}</div>
                        <div>{{ $t('We couldn\'t find what you were looking for') }}</div>
                        <div class="mt-6">
                            <router-link
                                active-class=""
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded focus:outline-none focus:shadow-outline"
                                exact-active-class=""
                                to="/"
                            >
                                {{ $t('Go home') }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import Navbar from "@/components/layout/shared/navbar";

export default {
    name: "not-found",
    metaInfo() {
        return {
            title: this.$i18n.t('Not found')
        }
    },
    components: {Navbar},
}
</script>
