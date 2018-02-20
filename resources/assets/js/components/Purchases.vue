<template>
    <div>
        <f-modal title="Create a purchase" small :show="creatingPurchase" textComplete="Create" @close="creatingPurchase = false" @complete="createPurchase">
            <form>
                <grid class="w-1/2 mx-auto mb-4" auto-rows="min-content" singles gap="1rem">
                    <label>
                        <span>Description</span>
                        <input v-model="newPurchase.description" placeholder="Description" maxlength="30">
                    </label>

                    <label>
                        <span>Amount</span>
                        <input v-model.number="newPurchase.amount" placeholder="£30.00">
                    </label>
                </grid>
            </form>
        </f-modal>

        <div class="card p-0">
            <div class="card-header">
                Your Purchases
                <button class="btn btn-sm float-right" @click.prevent="creatingPurchase = true">Create</button>
            </div>

            <div class="p-4" v-show="!purchases.length">
                <span class="text-grey-lightest text-base">
                    No purchases this month
                </span>
            </div>

            <div class="list pt-2" v-show="purchases.length">
                <div class="list-item" v-for="(purchase, index) in purchases" :key="index">
                    <span class="list-item-title">
                        {{ purchase.description }}<br />

                        <small>
                            {{ purchase.created_at | date }} &middot;
                            <a @click.prevent="deletePurchase(purchase.id)">Delete</a>
                        </small>
                    </span>

                    <span class="list-item-amount">{{ purchase.amount | currency }}</span>
                </div>

                <div class="list-item list-item-standout">
                    <span class="list-item-title">
                        Total<br />
                        <small>
                            {{ purchases.length }} purchases
                        </small>
                    </span>

                    <span class="list-item-amount">{{ total | currency }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                purchases: [],
                averageRate: 0,
                creatingPurchase: false,
                newPurchase: new Form({
                    description: '',
                    amount: null
                })
            };
        },

        computed: {
            total() {
                let value = 0;

                for (let purchase of this.purchases) {
                    value += purchase.amount;
                }

                return value;
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/purchases').then(r => (this.purchases = r.data));
            },

            createPurchase() {
                ajax
                    .post('/api/purchases', this.newPurchase.get())
                    .then(this.fetch)
                    .then(r => {
                        this.creatingPurchase = false;
                        this.newPurchase.reset();
                        EventBus.fire('updated');
                    });
            },

            deletePurchase(id) {
                ajax.delete(`/api/purchases/${id}`).then(r => {
                    this.fetch();
                    EventBus.fire('updated');
                });
            }
        },

        created() {
            this.fetch();
        }
    };
</script>
