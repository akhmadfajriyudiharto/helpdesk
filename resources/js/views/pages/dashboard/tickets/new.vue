<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveTicket">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Create ticket') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading.form"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Ticket details') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ $t('Ticket details and classification') }}.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="customer">{{ $t('Customer') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                            id="customer"
                                            v-model="ticket.user_id"
                                            :options="userList"
                                            option-label="name"
                                            required
                                            searchable
                                        >
                                            <template v-slot:selectedOption="props">
                                                <template v-if="props && !props.anySelected">
                                                    <span class="block truncate">{{ $t('Select an option') }}</span>
                                                </template>
                                                <template v-else>
                                                    <div class="flex-shrink-0 inline-block">
                                                        <img :src="props.option.avatar !== 'gravatar' ? props.option.avatar : props.option.gravatar" alt="Icon" class="w-5 h-auto rounded-full">
                                                    </div>
                                                    <span class="block truncate">{{ props.option.name }}</span>
                                                </template>
                                            </template>
                                            <template v-slot:selectOption="props">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0 inline-block">
                                                        <img :src="props.option.avatar !== 'gravatar' ? props.option.avatar : props.option.gravatar" alt="Icon" class="w-5 h-auto rounded-full">
                                                    </div>
                                                    <div :class="props.option.id === ticket.user_id ? 'font-semibold' : 'font-normal'" class="font-normal block truncate">
                                                        {{ props.option.name }}
                                                    </div>
                                                </div>
                                            </template>
                                        </input-select>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="subject">{{ $t('Subject') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="subject"
                                            v-model="ticket.subject"
                                            :placeholder="$t('Subject')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="department">{{ $t('Department') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                            id="department"
                                            v-model="ticket.department_id"
                                            :options="departmentList"
                                            option-label="name"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="status">{{ $t('Status') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                            id="status"
                                            v-model="ticket.status_id"
                                            :options="statusList"
                                            option-label="name"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="priority">{{ $t('Priority') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select
                                            id="priority"
                                            v-model="ticket.priority_id"
                                            :options="priorityList"
                                            option-label="name"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="ticket_body">{{ $t('Ticket body') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-wysiwyg
                                            id="ticket_body"
                                            v-model="ticket.body"
                                            :cannedReplyList="cannedReplyList"
                                            :plugins="{images: true, cannedReply: true, attachment: true, shortCode: true}"
                                            @selectUploadFile="selectUploadFile"
                                        >
                                            <template v-slot:top>
                                                <div :class="{'bg-gray-200': uploadingFileProgress > 0}" class="h-1 w-full">
                                                    <div :style="{width: uploadingFileProgress + '%'}" class="bg-blue-500 py-0.5"></div>
                                                </div>
                                            </template>
                                        </input-wysiwyg>
                                    </div>
                                </div>
                                <div v-if="ticket.attachments.length > 0" class="col-span-3">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-2">
                                        <template v-for="(attachment, index) in ticket.attachments">
                                            <attachment :details="attachment" v-on:remove="removeAttachment(index)"/>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <div class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/tickets"
                            >
                                {{ $t('Cancel') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Create ticket') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <input ref="fileInput" hidden type="file" @change="uploadFile($event)">
    </main>
</template>

<script>
export default {
    name: "new",
    metaInfo() {
        return {
            title: this.$i18n.t('Create ticket')
        }
    },
    data() {
        return {
            loading: {
                form: true,
                file: false,
            },
            uploadingFileProgress: 0,
            ticket: {
                user_id: null,
                subject: null,
                department_id: null,
                status_id: 1,
                priority_id: 1,
                body: '',
                attachments: [],
            },
            departmentList: [],
            userList: [],
            statusList: [],
            priorityList: [],
            cannedReplyList: [],
        }
    },
    mounted() {
        this.getFilters();
        this.getCannedReplies();
    },
    methods: {
        getFilters() {
            const self = this;
            self.loading.form = true;
            axios.get('api/dashboard/tickets/filters').then(function (response) {
                self.userList = response.data.customers;
                self.departmentList = response.data.departments;
                self.statusList = response.data.statuses;
                self.priorityList = response.data.priorities;
                self.loading.form = false;
            }).catch(function () {
                self.loading.form = false;
            })
        },
        getCannedReplies() {
            const self = this;
            axios.get('api/dashboard/tickets/canned-replies').then(function (response) {
                self.cannedReplyList = response.data;
            })
        },
        saveTicket() {
            const self = this;
            self.loading.form = true;
            axios.post('api/dashboard/tickets', self.ticket).then(function (response) {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/tickets/' + response.data.ticket.uuid + '/manage');
            }).catch(function () {
                self.loading.form = false;
            });
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
                'api/dashboard/tickets/attachments',
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
                self.ticket.attachments.push(response.data);
            }).catch(function () {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
            });
        },
        removeAttachment(attachment) {
            this.ticket.attachments.splice(attachment, 1);
        }
    },
}
</script>
