<template>
    <div class="flex flex-wrap" v-if="stats">
        <div class="md:w-1/4 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Income</span>
            <span class="inline-block w-full text-3xl">{{ (stats.income - stats.expenses) | currency }}</span>
            <span class="inline-block w-full text-sm text-grey-lightest">
                <span class="text-left mx-auto w-1/2">{{ stats.income | currency }}</span>
                <span class="text-right text-error mx-auto w-1/2">-{{ stats.expenses | currency }}</span>
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
            goalCompletion() {
                if (!this.stats.goal || !this.stats.income) {
                    return 0;
                }

                return Math.ceil(((this.stats.income - this.stats.expenses) / this.stats.goal) * 100);
            },

            goalAmount() {
                return this.stats.goal ? this.stats.goal : 0;
            },

            goalTimeLeft() {
                return Math.ceil(this.goalAmount / this.stats.averageWeeklyIncome);
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/summary')
                    .then(r => this.stats = r.data);
            },

            changeGoal() {
                let amount = prompt('Amount');

                if (amount !== null) {
                    ajax.put('/api/goal', { amount })
                        .then(r => {
                            this.stats.goal = amount;
                        });
                }
            }
        },

        created() {
            this.fetch();

            EventBus.listen('WeekSaved', this.fetch);
        }
    }
</script>
