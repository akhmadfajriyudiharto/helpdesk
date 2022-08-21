<template>
    <div :class="divPadding" class="flex items-center">
        <img :src="$store.state.settings.icon" alt="icon" class="h-8 w-auto mr-4"/>
        <div :class="textClass" class="inline-block text-xl font-semibold uppercase">{{ $store.state.settings.name }}</div>
    </div>
</template>

<script>
export default {
    name: "logo",
    props: {
        divPadding: {
            type: String,
            default: 'px-4',
            required: false
        },
        textClass: {
            type: String,
            default: 'text-gray-200',
            required: false
        }
    }
}
</script>
