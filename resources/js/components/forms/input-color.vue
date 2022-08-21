<template>
    <div>
        <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">{{ label }}</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <div class="relative flex items-stretch flex-grow focus-within:z-10">
                <div :style="{backgroundColor: input}" class="absolute rounded-l-md inset-y-0 left-0 w-10 flex items-center pointer-events-none border-r border-gray-400"/>
                <input
                    :id="id"
                    v-model="input"
                    :placeholder="placeholder"
                    :required="required"
                    aria-label="Color picker"
                    class="form-input rounded-none rounded-l-md pl-12 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                >
            </div>
            <div v-on-clickaway="closeDropdown" class="inline-block text-left">
                <button
                    class="-ml-px h-full relative rounded-r-md inline-flex items-center px-3 py-2 h-full border border-gray-400 text-sm leading-5 font-medium rounded-r-md hover:bg-gray-100 hover:text-gray-500 hover:bg-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                    type="button"
                    @click="dropdownOpen = !dropdownOpen"
                >
                    <svg-vue class="h-4 w-4 text-gray-700" icon="font-awesome.eye-dropper-solid"></svg-vue>
                </button>
                <transition
                    duration="100"
                    enter-active-class="transition ease-out duration-100"
                    enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <div v-show="dropdownOpen" class="origin-top-right absolute right-5 mt-1 w-56 rounded-md">
                        <chrome-picker
                            :disable-alpha="true"
                            :disable-fields="true"
                            :value="input"
                            @input="pickColor"
                        />
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import {Chrome} from 'vue-color';
import {mixin as clickaway} from 'vue-clickaway';

export default {
    name: "input-color",
    components: {
        'chrome-picker': Chrome,
    },
    mixins: [clickaway],
    props: {
        value: {
            required: false
        },
        id: {
            type: String,
            required: true
        },
        label: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            default: null
        },
        required: {
            type: Boolean,
            default: false
        },
    },
    computed: {
        input: {
            get() {
                return this.value
            },
            set(value) {
                this.$emit('input', value)
            }
        }
    },
    data() {
        return {
            dropdownOpen: false,
        }
    },
    methods: {
        pickColor(color) {
            this.input = color.hex;
        },
        closeDropdown() {
            this.dropdownOpen = false;
        },
    }
}
</script>
