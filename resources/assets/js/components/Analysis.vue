<template>
    <div class="card p-0">
        <div class="card-header">
            Earnings Analysis
        </div>

        <div v-if="this.weeks.length > 1" ref="chart"></div>

        <p v-if="this.weeks.length < 2" class="text-grey-lightest p-4">
            Not enough data yet
        </p>
    </div>
</template>

<script>
    import Chart from 'frappe-charts/dist/frappe-charts.min.esm';

    export default {
        data() {
            return {
                weeks: [],
                purchases: [],
                chart: null
            };
        },

        methods: {
            fetch() {
                return ajax.get('/api/analysis').then(r => {
                    this.weeks = r.data.weeks;
                    this.purchases = r.data.purchases;
                });
            },

            getFormattedWeeks() {
                let data = {
                    labels: [],
                    datasets: []
                };

                let values = [];
                let purchases = [];

                for (let week of this.weeks) {
                    let weekOfYear = moment(week.ending)
                        .week()
                        .toString();
                    let weekPurchaseAmount =
                        weekOfYear in this.purchases
                            ? this.purchases[weekOfYear]
                            : 0;

                    purchases.push((week.total - weekPurchaseAmount) / 100);

                    data.labels.push(moment(week.ending).format('DD/MM/YY'));
                    values.push(week.total / 100);
                }

                data.datasets.push({ values, color: 'red' });
                data.datasets.push({ values: purchases, color: 'blue' });

                return data;
            },

            createChart() {
                if (this.weeks.length < 2) return;

                this.chart = new Chart({
                    height: 250,
                    type: 'line',
                    region_fill: 1,
                    title: 'Weekly Earnings',
                    parent: this.$refs.chart,
                    data: this.getFormattedWeeks(),
                    format_tooltip_y: d => `£${d.toFixed(2)}`
                });
            }
        },

        created() {
            this.fetch().then(this.createChart);

            EventBus.listen('Updated', e => {
                this.fetch().then(r => {
                    let data = this.getFormattedWeeks();
                    this.chart.update_values(data.datasets, data.labels);
                });
            });
        }
    };
</script>
