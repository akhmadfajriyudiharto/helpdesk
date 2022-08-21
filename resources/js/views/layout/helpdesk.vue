<template>
    <div class="min-h-screen bg-gray-100">
        <navbar/>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from "@/components/layout/shared/navbar";

export default {
    name: "helpdesk",
    metaInfo() {
        return {
            title: this.$i18n.t('Helpdesk'),
            titleTemplate: '%s - ' + this.$store.state.settings.name
        }
    },
    components: {Navbar},
}
</script>
