<template>
    <div
        :class="(input && input.preview) ? 'has-preview' : null"
        class="image-input mt-1"
        @click="selectFile"
        @dragleave="dragleave"
        @dragover="dragover"
        @drop="drop"
    >
        <img v-if="(input && input.preview)" :src="input.preview" alt="Image">
        <input :id="id" ref="input" :accept="allowed.join()" hidden type="file" @change="changeFile($event)">
        <div class="image-input-render">
            <div class="image-input-info">
                {{ $t('Drag and drop or click to replace') }}
            </div>
            <button v-if="remove" class="btn-image-preview" type="button" @click.stop="removeFile">{{ $t('Remove') }}</button>
        </div>
        <div class="image-input-empty">
            <p class="image-input-empty-text">
                <svg-vue class="image-input-icon" icon="font-awesome.cloud-upload-light"></svg-vue>
                {{ $t('Drag and drop a file here or click') }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "image-input",
    props: {
        value: {
            required: false
        },
        id: {
            type: String,
            required: true
        },
        remove: {
            type: Boolean,
            default: true
        },
        allowed: {
            type: Array,
            default: function () {
                return ['image/png', 'image/x-citrix-png', 'image/x-png', 'image/jpeg', 'image/x-citrix-jpeg'];
            }
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
    methods: {
        selectFile() {
            this.$refs.input.click();
        },
        removeFile() {
            const self = this;
            self.input.file = null;
            self.input.preview = null;
        },
        changeFile(event) {
            event.preventDefault();
            const self = this;
            if (event.target.files.length) {
                if (self.allowed.includes(event.target.files[0].type)) {
                    self.input.file = event.target.files[0];
                    self.input.preview = URL.createObjectURL(event.target.files[0]);
                } else {
                    self.$notify({
                        title: self.$i18n.t('Unsupported file type').toString(),
                        text: self.$i18n.t('Only image type files are accepted').toString(),
                        type: 'error'
                    })
                }
            }
        },
        dragover(event) {
            event.preventDefault();
            if (!event.currentTarget.classList.contains('dragging')) {
                event.currentTarget.classList.add('dragging');
            }
        },
        dragleave(event) {
            event.currentTarget.classList.remove('dragging');
        },
        drop(event) {
            event.preventDefault();
            const self = this;
            if (event.dataTransfer.files.length) {
                if (self.allowed.includes(event.dataTransfer.files[0].type)) {
                    self.input.file = event.dataTransfer.files[0];
                    self.input.preview = URL.createObjectURL(event.dataTransfer.files[0]);
                } else {
                    self.$notify({
                        title: self.$i18n.t('Unsupported file type').toString(),
                        text: self.$i18n.t('Only image type files are accepted').toString(),
                        type: 'error'
                    })
                }
            }
            event.currentTarget.classList.remove('dragging');
        }
    }
}
</script>

<style lang="scss">
.image-input {
    @apply relative block border bg-white flex justify-center cursor-pointer h-48;

    &.has-preview {
        &:hover {
            .image-input-render {
                @apply inline;
            }
        }
    }

    &:not(.has-preview) {
        &:not(.dragging) {
            &:hover {
                background-size: 30px 30px;
                animation: stripes 2s linear infinite;
                background-image: linear-gradient(
                        -45deg,
                        theme('colors.gray.100') 25%,
                        transparent 25%,
                        transparent 50%,
                        theme('colors.gray.100') 50%,
                        theme('colors.gray.100') 75%,
                        transparent 75%,
                        transparent
                );
            }
        }

        .image-input-empty {
            @apply inline;
        }
    }

    > img {
        @apply max-w-full max-h-full p-2;
    }

    .image-input-render {
        @apply hidden absolute z-10 bg-gray-900 bg-opacity-50 w-full h-full;
    }

    .image-input-empty {
        @apply hidden relative z-10 h-full;
    }

    .image-input-info {
        @apply relative opacity-75 text-white w-full text-center;
        top: 50%;
        transform: translateY(-50%);
    }

    .image-input-empty-text {
        @apply relative text-gray-700 w-full text-center;
        top: 50%;
        transform: translateY(-50%);
    }

    .image-input-icon {
        @apply h-8 block ml-auto mr-auto;
    }

    .btn-image-preview {
        @apply absolute uppercase border border-2 border-white text-xs text-white py-1 px-2 z-20;
        top: 10px;
        right: 10px;
    }
}

@keyframes stripes {
    from {
        background-position: 0 0;
    }
    to {
        background-position: 60px 30px;
    }
}

</style>
