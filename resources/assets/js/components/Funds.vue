<template>
    <div>
        <f-modal title="Create a fund" small :show="creatingFund" textComplete="Create" @close="creatingFund = false" @complete="createFund">
            <form>
                <grid class="w-1/2 mx-auto mb-4" auto-rows="min-content" singles gap="1rem">
                    <label>
                        <span>Name</span>
                        <input v-model="newFund.name" placeholder="Name" maxlength="30">
                    </label>

                    <label>
                        <span>Goal</span>
                        <input v-model.number="newFund.goal" placeholder="£30.00">
                    </label>

                    <label>
                        <span>Frequency</span>
                        <select v-model="newFund.frequency">
                            <option value="week">Weekly</option>
                            <option value="month">Monthly</option>
                            <option value="year">Yearly</option>
                        </select>
                    </label>

                    <label>
                        <span v-tooltip="'When will the money next leave your account?'">Bills On</span>
                        <input type="date" v-model="newFund.bills_on">
                    </label>
                </grid>
            </form>
        </f-modal>

        <div class="card p-0">
            <div class="card-header">
                Your Funds
                <button class="btn btn-sm float-right" @click.prevent="creatingFund = true">Create</button>
            </div>

            <div class="p-4" v-show="!funds.length">
                <span class="text-grey-lightest text-base">
                    You have no funds yet
                </span>
            </div>

            <div class="list" v-show="funds.length">
                <div
                    class="list-item without-padding"
                    v-for="(fund, index) in funds"
                    :key="index">
                    <span class="list-item-title pt-2 px-4">
                        <p class="m-0">{{ fund.name }}</p>

                        <small class="opacity-75" v-tooltip="`Due ${billsOnNext(fund)}`">
                            {{ fund.frequency_full }}
                        </small>
                    </span>

                    <span class="list-item-amount text-right pt-2 px-4 pb-2">
                        <p class="m-0">
                            {{ fund.goal | currency }}
                        </p>

                        <small v-if="fund.amount_left > 0 && fund.amount_left < fund.goal" v-tooltip="'Amount left to deposit this period'" class="opacity-75">
                            {{ fund.amount_left | currency }}
                        </small>

                        <span v-if="fund.amount_left > 0 && fund.amount_left < fund.goal">&middot;</span>

                        <small class="opacity-75" v-tooltip="'Amount to deposit each week'">
                            {{ fund.per_week | currency }}
                        </small>
                    </span>

                    <div class="inline-block w-full h-1 overflow-hidden">
                        <span class="float-left h-full transition-all" :style="progressStyles(fund)"></span>
                    </div>
                </div>

                <div class="list-item list-item-standout">
                    <span class="list-item-title">
                        Total<br />
                        <small>{{ funds.length }} funds</small>
                    </span>

                    <span class="list-item-amount">
                        {{ total | currency }}<br />
                        <small class="opacity-75" v-tooltip="'Per Week'">
                            {{ totalPerWeek | currency }}
                        </small>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            //
        },

        data() {
            return {
                funds: [],
                creatingFund: false,
                newFund: new Form({
                    name: '',
                    goal: null,
                    frequency: null,
                    bills_on: null
                })
            };
        },

        computed: {
            total() {
                return _.sumBy(this.funds, 'goal');
            },

            totalPerWeek() {
                return _.sumBy(this.funds, 'per_week');
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/user/funds').then(r => {
                    this.funds = r.data;
                    EventBus.fire('funds', this.funds);
                });
            },

            createFund() {
                ajax
                    .post('/api/user/funds', this.newFund.get())
                    .then(this.fetch)
                    .then(r => {
                        this.creatingFund = false;
                        this.newFund.reset();
                    });
            },

            progressStyles(fund) {
                return {
                    width: `${fund.completion * 100}%`,
                    background: colorFromPercentage(fund.completion)
                };
            },

            billsOnNext(fund) {
                return moment(fund.bills_on_next).format('DD/MM/YYYY');
            }
        },

        created() {
            this.fetch();

            EventBus.listen('income', this.fetch);
        }
    };
</script>

<style scoped lang="scss">
    .slide-enter-active,
    .slide-leave-active {
        transition: width 0.3s ease;
    }

    .slide-enter,
    .slide-leave-to {
        width: 0;
    }
</style>
