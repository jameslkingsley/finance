<template>
    <div>
        <f-modal title="Create a savings goal" small :show="creatingSaving" textComplete="Create" @close="creatingSaving = false" @complete="createSaving">
            <form>
                <grid class="w-1/2 mx-auto mb-4" auto-rows="min-content" singles gap="1rem">
                    <label>
                        <span>Name</span>
                        <input v-model="newSaving.name" placeholder="Name" maxlength="30">
                    </label>

                    <label>
                        <span>Goal</span>
                        <input v-model.number="newSaving.goal" placeholder="£1000.00 (optional)">
                    </label>

                    <label>
                        <span v-tooltip="'Amount you wish to deposit each paycheck'">Deposit</span>
                        <input v-model.number="newSaving.deposit" placeholder="£30.00 (optional)">
                    </label>
                </grid>
            </form>
        </f-modal>

        <div class="card p-0">
            <div class="card-header">
                Your Savings
                <button class="btn btn-sm float-right" @click.prevent="creatingSaving = true">Create</button>
            </div>

            <div class="p-4" v-show="!savings.length">
                <span class="text-grey-lightest text-base">
                    You have no savings goal yet
                </span>
            </div>

            <div class="list" v-show="savings.length">
                <div
                    class="list-item without-padding"
                    v-for="(saving, index) in savings"
                    :key="index">
                    <span class="list-item-title pt-2 px-4">
                        <p class="m-0">{{ saving.name }}</p>

                        <small class="opacity-75" v-tooltip="'Amount to deposit each week'">
                            {{ saving.deposit | currency }}
                        </small>
                    </span>

                    <span class="list-item-amount text-right pt-2 px-4 pb-2">
                        <p class="m-0">
                            {{ saving.goal | currency }}
                        </p>

                        <small v-if="saving.amount_left" class="opacity-75" v-tooltip="'Amount left till goal met'">
                            {{ saving.amount_left | currency }}
                        </small>

                        <small v-else>
                            &nbsp;
                        </small>
                    </span>

                    <div class="inline-block w-full h-1 overflow-hidden">
                        <span class="float-left h-full transition-all" :style="progressStyles(saving)"></span>
                    </div>
                </div>

                <div class="list-item list-item-standout">
                    <span class="list-item-title">
                        Total<br />
                        <small>{{ savings.length }} saving goals</small>
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
        data() {
            return {
                savings: [],
                creatingSaving: false,
                newSaving: new Form({
                    name: '',
                    goal: null,
                    deposit: null
                })
            };
        },

        computed: {
            total() {
                return _.sumBy(this.savings, 'goal');
            },

            totalPerWeek() {
                return _.sumBy(this.savings, 'deposit');
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/user/savings').then(r => {
                    this.savings = r.data;
                    EventBus.fire('savings', this.savings);
                });
            },

            createSaving() {
                ajax
                    .post('/api/user/savings', this.newSaving.get())
                    .then(this.fetch)
                    .then(r => {
                        this.creatingSaving = false;
                        this.newSaving.reset();
                    });
            },

            progressStyles(saving) {
                return {
                    width: `${saving.completion * 100}%`,
                    background: colorFromPercentage(saving.completion)
                };
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
