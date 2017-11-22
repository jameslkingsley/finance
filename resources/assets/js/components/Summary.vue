<template>
    <div class="flex flex-wrap" v-if="stats">
        <div class="md:w-1/4 mb-8 md:mb-0 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Income</span>
            <span class="inline-block w-full text-3xl">{{ netIncome | currency }}</span>
            <span class="inline-block w-full text-sm text-grey-lightest">
                <span class="text-left mx-auto w-1/2">{{ stats.income | currency }}</span>
                <span class="text-right text-error mx-auto w-1/2">-{{ stats.expenses | currency }}</span>
            </span>
        </div>

        <div class="md:w-1/4 mb-8 md:mb-0 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Purchases</span>
            <span class="inline-block w-full text-3xl">{{ stats.purchases | currency }}</span>
            <span class="inline-block w-full text-sm text-grey-lightest">
                <span class="text-center mx-auto w-full">{{ purchasePercentage }}% of income</span>
            </span>
        </div>

        <div class="md:w-1/4 mb-8 md:mb-0 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Savings</span>
            <span class="inline-block w-full text-3xl" @click="changeSavings">{{ stats.savings | currency }}</span>
            <span class="inline-block w-full text-sm text-grey-lightest">
                <span class="text-center mx-auto w-full">{{ savingsToGo | currency }} to go</span>
            </span>
        </div>

        <div class="md:w-1/4 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Goal &middot; {{ goalCompletion }}%</span>

            <span class="inline-block w-full text-3xl" @click="changeGoal">
                <span>{{ goalAmount | currency }}</span>
            </span>

            <span class="inline-block w-full text-sm text-grey-lightest">
                <span class="text-center mx-auto w-full">{{ goalTimeLeft }} weeks to go</span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stats: null
            };
        },

        computed: {
            netIncome() {
                return this.stats.income - this.stats.expenses;
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
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/summary').then(r => (this.stats = r.data));
            },

            changeGoal() {
                let amount = prompt('Amount');

                if (amount !== null) {
                    ajax.put('/api/goal', { amount }).then(r => {
                        this.stats.goal = Number(amount);
                    });
                }
            },

            changeSavings() {
                let amount = prompt('Amount', this.stats.savings);

                if (amount !== null) {
                    ajax.put('/api/savings', { amount }).then(r => {
                        this.stats.savings = Number(amount);
                    });
                }
            }
        },

        created() {
            this.fetch();

            EventBus.listen('Updated', this.fetch);
        }
    };
</script>
