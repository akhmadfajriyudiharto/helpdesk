<template>
    <vue-element-loading
        :active="status"
        :delay="0"
        :is-full-screen="fullPage"
        background-color="#FFFFFF"
        color="#4299E1"
    />
</template>

<script>
export default {
    name: "loading",
    props: {
        status: {
            type: Boolean,
            required: true,
            default: true
        },
        fullPage: {
            type: Boolean,
            default: false
        },
    }
}
</script>
