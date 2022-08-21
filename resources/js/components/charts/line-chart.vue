<script>
import {Line, mixins} from 'vue-chartjs'

const {reactiveProp} = mixins;

export default {
    name: 'line-chart',
    extends: Line,
    mixins: [reactiveProp],
    props: {
        chartData: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
                legend: {
                    display: false
                },
                animation: false,
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted() {
        this.renderChart(this.chartData, this.options);
    },
    methods: {
        update() {
            this.$data._chart.update();
        }
    }
}
</script>
