<template>
    <div>
        <notifications class="max-w-md select-none" position="bottom right" width="100%">
            <template slot="body" slot-scope="props">
                <div class="inset-0 flex items-end justify-center pointer-events-none sm:items-start sm:justify-end">
                    <div class="w-full mx-4 mb-4 bg-white rounded-lg pointer-events-auto">
                        <div class="rounded-lg shadow-md border border-gray-200 overflow-hidden">
                            <div class="p-4" @click="props.close">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg-vue v-if="props.item.type === 'error'" class="h-6 w-6 text-red-400" icon="font-awesome.times-circle-light"></svg-vue>
                                        <svg-vue v-else-if="props.item.type === 'warning'" class="h-6 w-6 text-orange-400" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                        <svg-vue v-else-if="props.item.type === 'info'" class="h-6 w-6 text-blue-400" icon="font-awesome.info-circle-light"></svg-vue>
                                        <svg-vue v-else class="h-6 w-6 text-green-400" icon="font-awesome.check-circle-light"></svg-vue>
                                    </div>
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="text-sm leading-5 font-medium text-gray-900">
                                            {{ props.item.title }}
                                        </p>
                                        <p class="mt-1 text-sm leading-5 text-gray-500" v-html="props.item.text"/>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex">
                                        <button class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150" type="button" @click="props.close">
                                            <svg-vue class="h-5 w-5 p-px" icon="font-awesome.times-light"></svg-vue>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </notifications>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App"
}
</script>
