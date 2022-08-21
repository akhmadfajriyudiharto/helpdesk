<template>
    <div class="editor rounded-md shadow-sm">
        <slot name="top"/>
        <template v-if="readonly">
            <div class="border border-gray-400 p-4" v-html="input"></div>
        </template>
        <template v-else>
            <tinymce
                ref="editor"
                v-model="input"
                :d="id"
                :init="editorConfig"
            />
            <input :id="id" ref="imageInput" :accept="allowed.join()" hidden type="file" @change="uploadFile($event)">
        </template>
        <slot name="bottom"/>
        <div v-show="openSidebar" :class="{'z-1500': openSidebar}" class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                    <div class="relative w-screen max-w-md">
                        <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                            <button
                                aria-label="Close panel"
                                class="text-gray-100 hover:text-white transition ease-in-out duration-150"
                                type="button"
                                @click="closeSidebar"
                            >
                                <svg-vue class="h-6 w-6" icon="font-awesome.times-light"/>
                            </button>
                        </div>
                        <div class="h-full flex flex-col pt-6 bg-white shadow-xl">
                            <header class="px-4 sm:px-6 pb-6 border-b border-gray-200">
                                <h2 class="text-lg leading-7 font-medium text-gray-900">
                                    <template v-if="sidebar.shortCodeSelect">{{ $t('Short codes') }}</template>
                                    <template v-if="sidebar.cannedReplySelect">{{ $t('Canned replies') }}</template>
                                </h2>
                            </header>
                            <div class="relative flex-1 overflow-y-scroll">
                                <template v-if="sidebar.shortCodeSelect">
                                    // CONTENT
                                </template>
                                <template v-if="sidebar.cannedReplySelect">
                                    <template v-if="cannedReplyList.length > 0">
                                        <ul class="divide-y divide-gray-200 overflow-y-auto">
                                            <template v-for="cannedReply in cannedReplyList">
                                                <li class="px-6 py-5 relative hover:bg-gray-100 cursor-pointer" @click="setContent(cannedReply.body)">
                                                    <div class="text-sm leading-5 font-medium text-gray-900 truncate">
                                                        {{ cannedReply.name }}
                                                    </div>
                                                    <div class="text-sm leading-5 text-gray-500 truncate">
                                                        {{ cannedReply.body }}
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                    <template v-else>
                                        <div class="h-full flex">
                                            <div class="m-auto">
                                                <div class="grid grid-cols-1 justify-items-center h-full w-full px-4 py-10">
                                                    <div class="flex justify-center items-center">
                                                        <svg-vue class="h-full h-auto w-40 mb-8" icon="undraw.browsing"></svg-vue>
                                                    </div>
                                                    <div class="flex justify-center items-center">
                                                        <div class="w-full font-semibold text-xl">{{ $t('No records found') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import "tinymce/tinymce";
import "tinymce/icons/default";
import "tinymce/themes/silver";
import "tinymce/plugins/paste";
import "tinymce/plugins/link";
import "tinymce/plugins/image";
import "tinymce/plugins/code";
import "tinymce/plugins/fullscreen";
import "tinymce/plugins/autoresize";
import Editor from '@tinymce/tinymce-vue';

export default {
    name: "input-wysiwyg",
    components: {
        'tinymce': Editor,
    },
    props: {
        value: {
            required: false
        },
        id: {
            type: String,
            required: true
        },
        required: {
            type: Boolean,
            default: false
        },
        readonly: {
            type: Boolean,
            default: false
        },
        allowed: {
            type: Array,
            default: function () {
                return ['image/png', 'image/x-citrix-png', 'image/x-png', 'image/jpeg', 'image/x-citrix-jpeg'];
            }
        },
        plugins: {
            type: Object,
            default: function () {
                return {images: true};
            }
        },
        cannedReplyList: {
            type: Array,
            default: function () {
                return [];
            }
        }
    },
    computed: {
        input: {
            get() {
                return this.value
            },
            set(value) {
                this.$emit('input', value)
            }
        },
        openSidebar() {
            return this.sidebar.cannedReplySelect || this.sidebar.shortCodeSelect;
        }
    },
    data() {
        const self = this;
        return {
            editorConfig: {
                branding: false,
                browser_spellcheck: true,
                paste_as_text: true,
                statusbar: false,
                menubar: false,
                convert_urls: false,
                forced_root_block: false,
                element_format: 'html',
                default_link_target: '_blank',
                link_assume_external_targets: true,
                target_list: false,
                link_title: false,
                language: 'en',
                mobile: {
                    theme: 'silver'
                },
                contextmenu_never_use_native: true,
                plugins: 'paste image link code fullscreen autoresize',
                toolbar: 'undo redo | upload attachment link cannedReply shortCode | fullscreen code',
                setup: function (editor) {
                    if (self.plugins.images) {
                        editor.ui.registry.addButton('upload', {
                            icon: 'image',
                            onAction: function (_) {
                                self.$refs.imageInput.click();
                            }
                        });
                    }
                    if (self.plugins.cannedReply) {
                        editor.ui.registry.addButton('cannedReply', {
                            icon: 'comment-add',
                            onAction: function (_) {
                                alert('Working');
                            }
                        });
                    }
                    if (self.plugins.cannedReply) {
                        editor.ui.registry.addButton('cannedReply', {
                            icon: 'comment-add',
                            onAction: function (_) {
                                self.sidebar.cannedReplySelect = true;
                            }
                        });
                    }
                    if (self.plugins.attachment) {
                        editor.ui.registry.addButton('attachment', {
                            icon: 'upload',
                            onAction: function (_) {
                                self.$emit('selectUploadFile')
                            }
                        });
                    }
                    if (self.plugins.shortCode) {
                        // editor.ui.registry.addButton('shortCode', {
                        //     icon: 'template',
                        //     onAction: function (_) {
                        //         self.sidebar.shortCodeSelect = true;
                        //     }
                        // });
                    }
                }
            },
            sidebar: {
                shortCodeSelect: false,
                cannedReplySelect: false,
            }
        }
    },
    methods: {
        uploadFile(e) {
            const self = this;
            const formData = new FormData();
            formData.append('file', e.target.files[0]);
            axios.post('api/files', formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(function (response) {
                self.$refs.imageInput.value = null;
                self.$refs.editor.editor.insertContent('<img src="' + response.data.url + '" width="100%" height="100%" alt="' + response.data.name + '"/>');
            }).catch(function () {
                self.$refs.imageInput.value = null;
            });
        },
        closeSidebar() {
            this.sidebar.shortCodeSelect = false;
            this.sidebar.cannedReplySelect = false;
        },
        setContent(content) {
            this.$refs.editor.editor.insertContent(content);
            this.closeSidebar();
        }
    }
}
</script>

<style lang="scss">
.tox-fullscreen .tox.tox-tinymce.tox-fullscreen {
    z-index: 1040 !important;
}
</style>
