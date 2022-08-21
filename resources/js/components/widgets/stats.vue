<template>
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <loading :status="stats.open_tickets == null"/>
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    {{ $t('Open tickets') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ stats.open_tickets ? stats.open_tickets : 0 }}
                </dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <loading :status="stats.pending_tickets == null"/>
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    {{ $t('Pending tickets') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ stats.pending_tickets ? stats.pending_tickets : 0 }}
                </dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <loading :status="stats.solved_tickets == null"/>
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    {{ $t('Solved tickets') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ stats.solved_tickets ? stats.solved_tickets : 0 }}
                </dd>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <loading :status="stats.without_agent == null"/>
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    {{ $t('Without assign agent') }}
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ stats.without_agent ? stats.without_agent : 0 }}
                </dd>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "stats",
    data() {
        return {
            stats: {
                open_tickets: null,
                pending_tickets: null,
                solved_tickets: null,
                without_agent: null,
            }
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            const self = this;
            axios.get('api/dashboard/stats/count').then(function (response) {
                self.stats = response.data;
            });
        }
    },
}
</script>
