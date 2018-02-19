<template>
    <div>
        <div class="card p-0">
            <div class="card-header">
                This Month's Purchases
                <button class="btn btn-sm float-right" @click.prevent="newPurchase">New Purchase</button>
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
                            <span v-tooltip="'Based on your average rate'">&middot; {{ duration }} hours</span>
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
                averageRate: 0
            };
        },

        computed: {
            total() {
                let value = 0;

                for (let purchase of this.purchases) {
                    value += purchase.amount;
                }

                return value;
            },

            duration() {
                return Math.ceil(this.total / this.averageRate);
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/purchases').then(r => (this.purchases = r.data));
            },

            newPurchase() {
                let description = prompt('Description');

                if (description !== null) {
                    let amount = prompt('Amount');

                    if (amount !== null) {
                        ajax
                            .post('/api/purchases', {
                                description,
                                amount
                            })
                            .then(r => {
                                this.fetch();
                                EventBus.fire('Updated');
                            });
                    }
                }
            },

            deletePurchase(id) {
                ajax.delete(`/api/purchases/${id}`).then(r => {
                    this.fetch();
                    EventBus.fire('Updated');
                });
            }
        },

        created() {
            this.fetch();

            EventBus.listen(
                'AverageRate',
                averageRate => (this.averageRate = averageRate)
            );
        }
    };
</script>
