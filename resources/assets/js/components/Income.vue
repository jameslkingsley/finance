<template>
    <div>
        <div class="card p-0 overflow-hidden">
            <div class="card-header">
                Your Income

                <button
                    v-if="!hasAmount || finished"
                    class="btn btn-sm float-right"
                    @mousedown.prevent="deposit"
                    @mouseup.prevent="$refs.amount.focus()">
                    Deposit
                </button>

                <button
                    v-if="hasAmount && !finished"
                    :disabled="!hasAmount || completing || finished || afterFunds < 0"
                    class="btn btn-sm btn-primary float-right"
                    @click.prevent="complete"
                    v-tooltip="afterFunds < 0 ? 'You\'ve exceeded your income!' : ''">
                    Complete
                </button>
            </div>

            <div class="px-4 py-8 text-center" v-show="!finished">
                <p class="text-grey-lightest text-sm">This week's income</p>
                <input :class="{ small: hasAmount }" class="income-amount" ref="amount" @focus="$event.target.select()" v-model.number="amount" placeholder="£0.00">
            </div>

            <p class="text-center px-4 py-4 text-grey-lightest text-sm" v-show="hasAmount && !finished">
                Deposit your income into funds.
            </p>

            <div :class="{ 'border-t': !finished }" v-show="hasAmount || finished">
                <div class="list pb-0 list-ignore-last" v-show="funds.length">
                    <div
                        class="list-item"
                        :class="{ 'list-item-success': covered(fund), 'list-item-error': !covered(fund) }"
                        v-for="(fund, index) in funds"
                        :key="index">
                        <span v-if="fund.this_week > 0" class="list-item-title font-semibold">
                            <p class="m-0">{{ fund.name }}</p>

                            <small class="font-normal" v-tooltip="'Amount left to deposit this period'">
                                {{ fund.amount_left | currency }}
                            </small>

                            <span>&middot;</span>

                            <small class="font-normal" v-tooltip="'Amount you need to deposit this week'">
                                {{ fund.this_week | currency }}
                            </small>
                        </span>

                        <span v-if="fund.this_week > 0" class="list-item-amount text-right">
                            <input
                                class="plain font-semibold text-lg text-right pr-0"
                                @focus="$event.target.select()"
                                v-model.number="fund.deposit"
                                placeholder="£0.00">
                        </span>

                        <span v-else class="list-item-title font-semibold w-full">
                            <p class="m-0">
                                {{ fund.name }}
                                <i class="material-icons text-2xl float-right">check</i>
                            </p>
                        </span>
                    </div>
                </div>

                <div class="px-4 py-8 text-center">
                    <p class="text-grey-lightest text-sm">You're left with</p>
                    <p class="font-hairline text-6xl">{{ leftWith !== null ? leftWith : afterFunds | currency }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                funds: [],
                amount: null,
                leftWith: null,
                finished: false,
                completing: false
            };
        },

        computed: {
            hasAmount() {
                return this.amount > 0;
            },

            afterFunds() {
                let value = this.amount;

                for (let fund of this.funds) {
                    value -= fund.deposit;
                }

                return value * 100;
            }
        },

        methods: {
            complete() {
                this.completing = true;
                this.leftWith = this.afterFunds;

                ajax
                    .post('/api/user/income', {
                        funds: this.funds,
                        amount: this.amount
                    })
                    .then(r => {
                        this.finished = true;
                        this.completing = false;
                        EventBus.fire('income');
                        EventBus.fire('updated');
                    });
            },

            deposit() {
                this.leftWith = null;
                this.amount = null;
                this.completing = false;
                this.finished = false;
            },

            covered(fund) {
                let thisWeek = Number((fund.this_week / 100).toFixed(2));
                return fund.deposit >= thisWeek;
            }
        },

        created() {
            EventBus.listen('funds', funds => {
                this.funds = _.map(funds, fund => {
                    fund.deposit = Number((fund.deposit / 100).toFixed(2));
                    return fund;
                });
            });
        }
    };
</script>

<style scoped lang="scss">
    .income-amount,
    .income-after-funds {
        padding: 0;
        height: 64px;
        border: none;
        line-height: 0;
        font-size: 64px;
        font-weight: 100;
        box-shadow: none;
        text-align: center;

        &.small {
            height: 48px;
            font-size: 48px;
        }

        &:before {
            content: '£';
        }
    }
</style>
