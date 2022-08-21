<template>
    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="py-0.5 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                            {{ $t('Ticket details') }}
                        </h2>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <router-link
                            class="btn btn-blue shadow-sm rounded-md"
                            to="/tickets/list"
                        >
                            {{ $t('Return to tickets list') }}
                        </router-link>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-10 my-6 bg-white shadow overflow-hidden sm:rounded-md">
                    <loading :status="loading.form"/>
                    <div class="sm:flex sm:items-center py-3 max-w-full">
                        <div class="px-6 sm:pl-6 sm:pr-3 sm:flex-1 sm:w-3/4">
                            <div class="text-xl truncate">{{ ticket.subject }}</div>
                        </div>
                        <div class="px-6 sm:pl-3 sm:pr-6 sm:flex-1 sm:w-1/4">
                            <div class="flex items-center sm:float-right">
                                <div class="text-sm sm:pr-2">{{ ticket.created_at | momentFormatDateTimeAgo }}</div>
                                <button class="flex items-center btn btn-white p-2 ml-3 sm:ml-0" type="button" @click="replyForm = true">
                                    <svg-vue class="h-4 w-4 mr-2" icon="font-awesome.reply-regular"></svg-vue>
                                    {{ $t('Reply') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-if="replyForm" class="px-6 py-3 border-t">
                        <loading :status="loading.reply"/>
                        <form @submit.prevent="addReply">
                            <input-wysiwyg
                                id="ticket_body"
                                v-model="ticketReply.body"
                                :plugins="{images: true, attachment: true, shortCode: true}"
                                @selectUploadFile="selectUploadFile"
                            >
                                <template v-slot:top>
                                    <div :class="{'bg-gray-200': uploadingFileProgress > 0}" class="h-1 w-full">
                                        <div :style="{width: uploadingFileProgress + '%'}" class="bg-blue-500 py-0.5"></div>
                                    </div>
                                </template>
                                <template v-slot:bottom>
                                    <div class="flex justify-between border border-t-0">
                                        <button
                                            class="btn btn-secondary rounded-none"
                                            type="button"
                                            @click="discardReply"
                                        >
                                            {{ $t('Discard') }}
                                        </button>
                                        <button
                                            class="btn btn-green rounded-none"
                                            type="submit"
                                        >
                                            {{ $t('Send reply') }}
                                        </button>
                                    </div>
                                </template>
                            </input-wysiwyg>
                        </form>
                        <input ref="fileInput" hidden type="file" @change="uploadFile($event)">
                        <template v-if="ticketReply.attachments.length > 0">
                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                                <template v-for="(attachment, index) in ticketReply.attachments">
                                    <attachment :details="attachment" v-on:remove="removeAttachment(index)"/>
                                </template>
                            </div>
                        </template>
                    </div>
                    <template v-if="ticket.ticketReplies.length > 0">
                        <template v-for="ticketReply in ticket.ticketReplies">
                            <div class="flex p-6 border-t">
                                <img
                                    :alt="$t('Avatar')"
                                    :src="ticketReply.user.avatar !== 'gravatar' ? ticketReply.user.avatar : ticketReply.user.gravatar"
                                    class="h-12 w-12 hidden sm:inline"
                                />
                                <div class="sm:pl-6 pb-2 w-full">
                                    <div class="md:flex md:items-center pb-1">
                                        <div class="md:flex-1 text-lg font-semibold text-gray-800">
                                            {{ ticketReply.user.name }}
                                        </div>
                                        <div class="md:flex-1">
                                            <div class="md:float-right text-sm">
                                                {{ ticketReply.created_at | momentFormatDateTime }}
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 ticket-reply-body" v-html="ticketReply.body"/>
                                    <template v-if="ticketReply.attachments.length > 0">
                                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                                            <template v-for="attachment in ticketReply.attachments">
                                                <attachment :details="attachment" :remove-button="false"/>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </template>
                    <template v-else>
                        <div class="h-full flex border-t">
                            <div class="m-auto">
                                <div class="grid grid-cols-1 justify-items-center h-full w-full py-24">
                                    <div class="flex justify-center items-center">
                                        <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <div class="w-full font-semibold text-2xl">{{ $t('This ticket has no conversations') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    name: "index",
    metaInfo() {
        return {
            title: this.$i18n.t('Ticket details')
        }
    },
    data() {
        return {
            loading: {
                form: true,
                reply: false,
                file: false,
            },
            replyForm: false,
            uploadingFileProgress: 0,
            ticket: {
                subject: null,
                created_at: null,
                ticketReplies: [],
            },
            ticketReply: {
                status_id: null,
                body: '',
                attachments: [],
            },
        }
    },
    filters: {
        momentFormatDateTime: function (value) {
            return moment(value).locale(window.app.app_date_locale).format(window.app.app_date_format + ' HH:mm');
        },
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    mounted() {
        this.getTicket();
    },
    methods: {
        getTicket() {
            const self = this;
            self.loading.form = true;
            axios.get('api/tickets/' + self.$route.params.uuid).then(function (response) {
                self.loading.form = false;
                self.ticket = response.data;
            }).catch(function () {
                self.$router.push('/tickets/list');
            });
        },
        addReply() {
            const self = this;
            self.loading.reply = true;
            axios.post('api/tickets/' + self.$route.params.uuid + '/reply', self.ticketReply).then(function (response) {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.discardReply();
                self.ticket = response.data.ticket;
                self.loading.reply = false;
            }).catch(function () {
                self.loading.reply = false;
            });
        },
        discardReply() {
            this.ticketReply.body = '';
            this.ticketReply.attachments = [];
            this.replyForm = false;
        },
        selectUploadFile() {
            if (!this.loading.file) {
                this.$refs.fileInput.click();
            } else {
                this.$notify({
                    title: this.$i18n.t('Error').toString(),
                    text: this.$i18n.t('A file is being uploaded').toString(),
                    type: 'warning'
                });
            }
        },
        uploadFile(e) {
            const self = this;
            const formData = new FormData();
            self.loading.file = true;
            formData.append('file', e.target.files[0]);
            axios.post(
                'api/tickets/attachments',
                formData,
                {
                    headers: {'Content-Type': 'multipart/form-data'},
                    onUploadProgress: function (progressEvent) {
                        self.uploadingFileProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                    }.bind(this)
                }
            ).then(function (response) {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
                self.ticketReply.attachments.push(response.data);
            }).catch(function () {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
            });
        },
        removeAttachment(attachment) {
            this.ticketReply.attachments.splice(attachment, 1);
        }
    }
}
</script>
