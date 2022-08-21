<template>
    <div class="flex items-center border w-full h-12 py-3 px-2 mb-1 mr-1">
        <div class="mr-2">
            <svg-vue v-if="details.extension === '7zip'" class="h-5 w-5" icon="file-extension.7zip"/>
            <svg-vue v-else-if="details.extension === 'ace'" class="h-5 w-5" icon="file-extension.ace"/>
            <svg-vue v-else-if="details.extension === 'aep'" class="h-5 w-5" icon="file-extension.aep"/>
            <svg-vue v-else-if="details.extension === 'aepx'" class="h-5 w-5" icon="file-extension.aepx"/>
            <svg-vue v-else-if="details.extension === 'aet'" class="h-5 w-5" icon="file-extension.aet"/>
            <svg-vue v-else-if="details.extension === 'ai'" class="h-5 w-5" icon="file-extension.ai"/>
            <svg-vue v-else-if="details.extension === 'ait'" class="h-5 w-5" icon="file-extension.ait"/>
            <svg-vue v-else-if="details.extension === 'avi'" class="h-5 w-5" icon="file-extension.avi"/>
            <svg-vue v-else-if="details.extension === 'bmp'" class="h-5 w-5" icon="file-extension.bmp"/>
            <svg-vue v-else-if="details.extension === 'c'" class="h-5 w-5" icon="file-extension.c"/>
            <svg-vue v-else-if="details.extension === 'css'" class="h-5 w-5" icon="file-extension.css"/>
            <svg-vue v-else-if="details.extension === 'doc'" class="h-5 w-5" icon="file-extension.doc"/>
            <svg-vue v-else-if="details.extension === 'docx'" class="h-5 w-5" icon="file-extension.docx"/>
            <svg-vue v-else-if="details.extension === 'dotx'" class="h-5 w-5" icon="file-extension.dotx"/>
            <svg-vue v-else-if="details.extension === 'eps'" class="h-5 w-5" icon="file-extension.eps"/>
            <svg-vue v-else-if="details.extension === 'flv'" class="h-5 w-5" icon="file-extension.flv"/>
            <svg-vue v-else-if="details.extension === 'gif'" class="h-5 w-5" icon="file-extension.gif"/>
            <svg-vue v-else-if="details.extension === 'html'" class="h-5 w-5" icon="file-extension.html"/>
            <svg-vue v-else-if="details.extension === 'java'" class="h-5 w-5" icon="file-extension.java"/>
            <svg-vue v-else-if="details.extension === 'jpeg'" class="h-5 w-5" icon="file-extension.jpeg"/>
            <svg-vue v-else-if="details.extension === 'jpg'" class="h-5 w-5" icon="file-extension.jpg"/>
            <svg-vue v-else-if="details.extension === 'js'" class="h-5 w-5" icon="file-extension.js"/>
            <svg-vue v-else-if="details.extension === 'less'" class="h-5 w-5" icon="file-extension.less"/>
            <svg-vue v-else-if="details.extension === 'm4a'" class="h-5 w-5" icon="file-extension.m4a"/>
            <svg-vue v-else-if="details.extension === 'mid'" class="h-5 w-5" icon="file-extension.mid"/>
            <svg-vue v-else-if="details.extension === 'mp3'" class="h-5 w-5" icon="file-extension.mp3"/>
            <svg-vue v-else-if="details.extension === 'mp4'" class="h-5 w-5" icon="file-extension.mp4"/>
            <svg-vue v-else-if="details.extension === 'mpg'" class="h-5 w-5" icon="file-extension.mpg"/>
            <svg-vue v-else-if="details.extension === 'odf'" class="h-5 w-5" icon="file-extension.odf"/>
            <svg-vue v-else-if="details.extension === 'ods'" class="h-5 w-5" icon="file-extension.ods"/>
            <svg-vue v-else-if="details.extension === 'odt'" class="h-5 w-5" icon="file-extension.odt"/>
            <svg-vue v-else-if="details.extension === 'otp'" class="h-5 w-5" icon="file-extension.otp"/>
            <svg-vue v-else-if="details.extension === 'ots'" class="h-5 w-5" icon="file-extension.ots"/>
            <svg-vue v-else-if="details.extension === 'ott'" class="h-5 w-5" icon="file-extension.ott"/>
            <svg-vue v-else-if="details.extension === 'pdf'" class="h-5 w-5" icon="file-extension.pdf"/>
            <svg-vue v-else-if="details.extension === 'php'" class="h-5 w-5" icon="file-extension.php"/>
            <svg-vue v-else-if="details.extension === 'png'" class="h-5 w-5" icon="file-extension.png"/>
            <svg-vue v-else-if="details.extension === 'ppt'" class="h-5 w-5" icon="file-extension.ppt"/>
            <svg-vue v-else-if="details.extension === 'pptx'" class="h-5 w-5" icon="file-extension.pptx"/>
            <svg-vue v-else-if="details.extension === 'psd'" class="h-5 w-5" icon="file-extension.psd"/>
            <svg-vue v-else-if="details.extension === 'py'" class="h-5 w-5" icon="file-extension.py"/>
            <svg-vue v-else-if="details.extension === 'qt'" class="h-5 w-5" icon="file-extension.qt"/>
            <svg-vue v-else-if="details.extension === 'rar'" class="h-5 w-5" icon="file-extension.rar"/>
            <svg-vue v-else-if="details.extension === 'raw'" class="h-5 w-5" icon="file-extension.raw"/>
            <svg-vue v-else-if="details.extension === 'svg'" class="h-5 w-5" icon="file-extension.svg"/>
            <svg-vue v-else-if="details.extension === 'tga'" class="h-5 w-5" icon="file-extension.tga"/>
            <svg-vue v-else-if="details.extension === 'tgz'" class="h-5 w-5" icon="file-extension.tgz"/>
            <svg-vue v-else-if="details.extension === 'txt'" class="h-5 w-5" icon="file-extension.txt"/>
            <svg-vue v-else-if="details.extension === 'wav'" class="h-5 w-5" icon="file-extension.wav"/>
            <svg-vue v-else-if="details.extension === 'xls'" class="h-5 w-5" icon="file-extension.xls"/>
            <svg-vue v-else-if="details.extension === 'xlsx'" class="h-5 w-5" icon="file-extension.xlsx"/>
            <svg-vue v-else-if="details.extension === 'xml'" class="h-5 w-5" icon="file-extension.xml"/>
            <svg-vue v-else-if="details.extension === 'zip'" class="h-5 w-5" icon="file-extension.zip"/>
            <svg-vue v-else class="h-5 w-5" icon="file-extension.default"/>
        </div>
        <div class="truncate text-sm text-gray-800 mr-2 w-full">{{ details.name }}</div>
        <div class="text-xs text-gray-500 mr-2">{{ details.size | prettyBytes }}</div>
        <button v-if="downloadButton" class="mr-2" type="button" @click="download">
            <svg-vue class="h-5 w-5 text-gray-800" icon="font-awesome.arrow-to-bottom-light"></svg-vue>
        </button>
        <button v-if="removeButton" type="button" @click="$emit('remove')">
            <svg-vue class="h-5 w-5 text-gray-800" icon="font-awesome.times-light"></svg-vue>
        </button>
    </div>
</template>

<script>
export default {
    name: "attachment",
    props: {
        details: {
            type: Object,
            required: true
        },
        downloadButton: {
            type: Boolean,
            default: true,
        },
        removeButton: {
            type: Boolean,
            default: true,
        }
    },
    methods: {
        download() {
            if (this.details.url === null) {
                window.open(this.details.download + '?token=' + localStorage.getItem('token'), '_blank');
            } else {
                window.open(this.details.download, '_blank');
            }
        }
    }
}
</script>
