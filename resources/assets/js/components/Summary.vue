<template>
    <div>
        <div class="card p-0">
            <div class="card-header">
                This Month's Report
            </div>

            <grid template-rows="1fr" doubles class="py-4 items-center" style="height: calc(100% - 57px)" v-if="stats">
                <div class="text-center">
                    <span class="inline-block w-full text-base text-grey-lightest">You Have</span>
                    <span class="inline-block w-full text-3xl" v-tooltip="'Amount you have to spend'">{{ netIncome | currency }}</span>
                    <span class="inline-block w-full text-sm text-grey-lightest">
                        <span class="text-left mx-auto w-1/2" v-tooltip="'Income before funds'">{{ stats.income | currency }}</span>
                        <span class="text-right text-warning mx-auto w-1/2" v-tooltip="'Total funds deducted'">-{{ stats.transactions | currency }}</span>
                    </span>
                </div>

                <div class="text-center">
                    <span class="inline-block w-full text-base text-grey-lightest">Purchases</span>
                    <span class="inline-block w-full text-3xl">{{ stats.purchases | currency }}</span>
                    <span class="inline-block w-full text-sm text-grey-lightest">
                        <span class="text-center mx-auto w-full">{{ purchasePercentage }}% of income</span>
                    </span>
                </div>
            </grid>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stats: null,
                lifeTick: 0
            };
        },

        computed: {
            netIncome() {
                return this.stats.income - this.stats.transactions;
            },

            savingsToGo() {
                return this.stats.goal - this.stats.savings;
            },

            goalCompletion() {
                if (!this.stats.goal || !this.stats.savings) {
                    return 0;
                }

                return Math.ceil(this.stats.savings / this.stats.goal * 100);
            },

            goalAmount() {
                return this.stats.goal ? this.stats.goal : 0;
            },

            goalTimeLeft() {
                if (!this.stats.averageWeeklyIncome) {
                    return 0;
                }

                return Math.ceil(
                    (this.goalAmount - this.stats.savings) /
                        this.stats.averageWeeklyIncome
                );
            },

            purchasePercentage() {
                if (!this.stats.purchases || !this.netIncome) {
                    return 0;
                }

                return Math.ceil(this.stats.purchases / this.netIncome * 100);
            },

            lifePercentage() {
                let born = moment(this.stats.born).add(18, 'years');
                let duration = moment.duration(moment().diff(born));
                let hours = duration.asHours();
                let hoursInLife = 8760 * 52;
                return Math.floor(hours / hoursInLife * 100);
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/summary').then(r => {
                    this.stats = r.data;
                    EventBus.fire('Born', this.stats.born);
                    EventBus.fire('AverageRate', this.stats.averageRate);
                });
            },

            changeGoal() {
                let amount = prompt('Amount');

                if (amount !== null) {
                    ajax.put('/api/goal', { amount }).then(r => {
                        this.stats.goal = Number(r.data);
                    });
                }
            },

            changeSavings() {
                let amount = prompt('Amount', this.stats.savings / 100);

                if (amount !== null) {
                    ajax.put('/api/savings', { amount }).then(r => {
                        this.stats.savings = Number(r.data);
                    });
                }
            },

            setBornDate() {
                let born = prompt('Born Date in Format: YYYY-MM-DD');

                if (born !== null) {
                    ajax.put('/api/user', { born }).then(r => {
                        this.stats.born = born;
                        EventBus.fire('Born', born);
                    });
                }
            }
        },

        created() {
            this.fetch();

            EventBus.listen('Updated', this.fetch);

            setInterval(() => {
                if (!this.stats) return;
                if (!this.stats.born) return;
                let born = moment(this.stats.born);
                let duration = moment.duration(moment().diff(born));
                let hours = duration.asHours();
                let hoursInLife = 8760 * 100;
                let percentage = hours / hoursInLife * 100;
                this.lifeTick = percentage
                    .toString()
                    .split('.')[1]
                    .substring(0, 14);
            }, 1000);
        }
    };
</script>
