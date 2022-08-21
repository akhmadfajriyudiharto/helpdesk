<template>
    <div v-on-clickaway="closeDropdown" class="relative">
        <div class="inline-block w-full rounded-md shadow-sm cursor-pointer">
            <button
                aria-expanded="true"
                aria-haspopup="listbox"
                aria-labelledby="listbox-label"
                class="relative w-full rounded-md border border-gray-400 bg-white text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                type="button"
                @click="openDropdown"
            >
                <template>
                    <div class="flex items-center space-x-3">
                        <template v-if="open && searchable">
                            <div class="relative w-full">
                                <input
                                    ref="search"
                                    v-model="search"
                                    :placeholder="$t('Search')"
                                    aria-label="Search"
                                    class="pl-3 pr-10 py-2 relative w-full rounded-md focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    @click.prevent
                                >
                            </div>
                        </template>
                        <div v-else class="flex items-center space-x-3 w-full pl-3 pr-10 py-2">
                            <template v-if="!anySelected">
                                <span class="block truncate">{{ $t('Select an option') }}</span>
                            </template>
                            <template v-else-if="multiple">
                                <span class="block truncate">{{ $t('Selected') }} {{ Object.keys(selected).length }} {{ $t('options') }}</span>
                            </template>
                            <template v-else>
                                <template v-for="option in options">
                                    <template v-if="option[optionKey] === selected">
                                        <slot :anySelected="anySelected" :option="option" name="selectedOption">
                                            <span class="block truncate">{{ option[optionLabel] }}</span>
                                        </slot>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </template>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>
                </span>
            </button>
        </div>
        <div v-show="open" class="absolute z-20 mt-1 mb-2 w-full rounded-md bg-white shadow-lg">
            <ul
                class="max-h-60  rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5"
                role="listbox"
                tabindex="-1"
            >
                <template v-if="!searchable">
                    <li
                        v-if="!required"
                        id="listbox-item-0"
                        class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100"
                        role="option"
                        @click="selectOption(null)"
                    >
                        <div class="flex items-center space-x-3">
                            <div :class="!anySelected ? 'font-semibold' : 'font-normal'" class="font-normal block truncate">
                                {{ $t('Select an option') }}
                            </div>
                        </div>
                    </li>
                </template>
                <template v-if="Object.keys(filteredOptions).length === 0">
                    <li
                        id="listbox-item-empty"
                        class="text-gray-900 select-none relative py-2 pl-3 pr-9"
                        role="option"
                    >
                        <slot :anySelected="anySelected" name="notFound">
                            <div class="flex items-center space-x-3">
                                <div class="font-normal block truncate font-normal">
                                    {{ $t('No results found') }}
                                </div>
                            </div>
                        </slot>
                    </li>
                </template>
                <template v-else>
                    <template v-for="(option, index) in filteredOptions">
                        <li
                            :id="'listbox-item-' + index"
                            class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100"
                            role="option"
                            @click="selectOption(option[optionKey])"
                        >
                            <slot :anySelected="anySelected" :option="option" name="selectOption">
                                <div class="flex items-center space-x-3">
                                    <template v-if="multiple">
                                        <div :class="Object.values(selected).indexOf(option[optionKey]) > -1 ? 'font-semibold' : 'font-normal'" class="font-normal block truncate">
                                            {{ option[optionLabel] }}
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div :class="option[optionKey] === selected ? 'font-semibold' : 'font-normal'" class="font-normal block truncate">
                                            {{ option[optionLabel] }}
                                        </div>
                                    </template>
                                </div>
                            </slot>
                        </li>
                    </template>
                </template>
            </ul>
        </div>
    </div>
</template>

<script>
import {mixin as clickaway} from 'vue-clickaway';

export default {
    name: "input-select",
    mixins: [clickaway],
    props: {
        value: {
            type: [String, Number, Array, Object],
            required: false
        },
        options: {
            type: Array,
            required: true
        },
        optionKey: {
            type: String,
            default: 'id'
        },
        optionLabel: {
            type: String,
            default: 'value'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        searchable: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
    },
    computed: {
        selected: {
            get() {
                return this.value
            },
            set(selected) {
                this.$emit('input', selected)
            }
        },
        anySelected() {
            if (this.multiple) {
                return Object.keys(this.selected).length !== 0;
            }
            return this.selected !== null;
        },
        filteredOptions() {
            const self = this;
            return self.options.filter(option => {
                if (self.search) {
                    return option[self.optionLabel].toLowerCase().includes(self.search.toLowerCase());
                }
                return true;
            })
        }
    },
    watch: {
        selected() {
            this.$emit('change');
        },
        open(e) {
            const self = this;
            if (e === true && self.searchable) {
                setTimeout(function () {
                    self.$refs.search.focus();
                }, 100);
            }
        }
    },
    data() {
        return {
            open: false,
            search: null,
        }
    },
    methods: {
        openDropdown() {
            const self = this;
            if (self.open && self.searchable && (self.search === null || self.search === '')) {
                self.open = false;
                self.search = null;
            } else if (self.open && !self.searchable) {
                self.open = false;
            } else {
                self.open = true;
                if (self.searchable) {
                    setTimeout(function () {
                        self.$refs.search.focus();
                    }, 100);
                }
            }
        },
        closeDropdown() {
            this.open = false;
            this.search = null;
        },
        selectOption(option) {
            if (this.multiple) {
                if (option === null) {
                    this.selected = [];
                } else {
                    if (this.selected.indexOf(option) > -1) {
                        this.selected.splice(this.selected.indexOf(option), 1);
                    } else {
                        this.selected.push(option);
                    }
                }
            } else {
                this.selected = option;
            }
            this.closeDropdown();
        }
    }
}
</script>
