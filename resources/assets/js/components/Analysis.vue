<template>
    <div v-if="this.weeks.length > 1" ref="chart"></div>
</template>

<script>
    import Chart from "frappe-charts/dist/frappe-charts.min.esm";

    export default {
        data() {
            return {
                weeks: [],
                chart: null
            };
        },

        methods: {
            fetch() {
                return ajax.get('/api/analysis')
                    .then(r => {
                        this.weeks = r.data.weeks;
                    });
            },

            getFormattedWeeks() {
                let data = {
                    labels: [],
                    datasets: []
                };

                let values = [];

                for (let week of this.weeks) {
                    data.labels.push(moment(week.ending).format('DD/MM/YY'));
                    values.push(week.total);
                }

                data.datasets.push({ values });

                return data;
            },

            createChart() {
                if (this.weeks.length < 2) return;

                this.chart = new Chart({
                    parent: this.$refs.chart,
                    title: "Weekly Earnings",
                    data: this.getFormattedWeeks(),
                    type: 'line',
                    height: 250,
                    heatline: 1,
                    region_fill: 1,
                    format_tooltip_y: d => formatAsCurrency(d)
                })
            }
        },

        created() {
            this.fetch().then(this.createChart);

            EventBus.listen('WeekSaved', e => {
                this.fetch().then(r => {
                    this.chart.update_values(this.getFormattedWeeks().datasets, this.getFormattedWeeks().labels);
                });
            });
        }
    }
</script>
