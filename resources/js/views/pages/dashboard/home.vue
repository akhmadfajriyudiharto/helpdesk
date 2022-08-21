<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Dashboard') }}</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <template v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.StatsController']">
                <div class="py-4">
                    <stats/>
                </div>
                <div class="py-4">
                    <opened-tickets/>
                </div>
            </template>
        </div>
    </main>
</template>

<script>
import Stats from "@/components/widgets/stats";
import OpenedTickets from "@/components/widgets/opened-tickets";

export default {
    name: "home",
    metaInfo() {
        return {
            title: this.$i18n.t('Dashboard')
        }
    },
    components: {OpenedTickets, Stats}
}
</script>
