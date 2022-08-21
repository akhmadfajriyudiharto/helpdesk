<template>
    <div class="grid grid-cols-1 gap-6">
        <div class="flex flex-col bg-white rounded-lg shadow">
            <div class="p-4">
                <div class="font-semibold">
                    {{ $t('Opened tickets this year') }}
                </div>
            </div>
            <div class="p-4">
                <loading :status="loading"/>
                <line-chart ref="chart" :chart-data="chartData" :height="350"></line-chart>
            </div>
        </div>
    </div>
</template>

<script>
import LineChart from "@/components/charts/line-chart";

export default {
    name: "opened-tickets",
    components: {LineChart},
    data() {
        return {
            loading: true,
            chartData: {
                labels: [
                    this.$t('Jan'), this.$t('Feb'), this.$t('Mar'), this.$t('Apr'), this.$t('May'), this.$t('Jun'), this.$t('Jul'), this.$t('Aug'), this.$t('Sept'), this.$t('Oct'), this.$t('Nov'), this.$t('Dec')
                ],
                datasets: [
                    {
                        label: this.$i18n.t('Tickets'),
                        backgroundColor: '#4299e1',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    }
                ],
            }
        }
    },
    computed: {
        datasets() {
            return this.chartData.datasets[0].data
        }
    },
    watch: {
        datasets() {
            this.$refs.chart.update();
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/stats/opened-tickets').then(function (response) {
                self.chartData.datasets[0].data = response.data;
                self.loading = false;
            });
        }
    },
}
</script>
