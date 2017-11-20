<template>
    <div>
        <span class="text-left uppercase font-semibold w-full text-sm text-grey-lightest">
            This Month's Purchases
            <a class="float-right text-grey-lightest opacity-50 hover:underline cursor-pointer" @click.prevent="newPurchase">New Purchase</a>
        </span>

        <div class="card p-0 w-full mt-2">
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
                            {{ purchase.created_at | date }}
                            &middot;
                            <a @click.prevent="deletePurchase(purchase.id)">Delete</a>
                        </small>
                    </span>

                    <span class="list-item-amount">{{ purchase.amount | currency }}</span>
                </div>

                <div class="list-item list-item-standout">
                    <span class="list-item-title">
                        Total<br />
                        <small>{{ purchases.length }} purchases</small>
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
                purchases: []
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
                ajax.get('/api/purchases')
                    .then(r => this.purchases = r.data);
            },

            newPurchase() {
                let description = prompt('Description');

                if (description !== null) {
                    let amount = prompt('Amount');

                    if (amount !== null) {
                        ajax.post('/api/purchases', { description, amount })
                            .then(r => {
                                this.fetch();
                                EventBus.fire('Updated');
                            });
                    }
                }
            },

            deletePurchase(id) {
                ajax.delete(`/api/purchases/${id}`)
                    .then(r => {
                        this.fetch();
                        EventBus.fire('Updated');
                    });
            }
        },

        created() {
            this.fetch();
        }
    }
</script>
