<template>
    <div>
        <button class="btn float-right mb-4 text-xs" @click.prevent="newPurchase">
            New Purchase
        </button>

        <span class="text-grey-lightest text-base" v-show="!purchases.length">
            No purchases this month
        </span>

        <table class="table" v-show="purchases.length">
            <thead>
                <tr>
                    <th align="left" width="30"></th>
                    <th align="left">Description</th>
                    <th align="left" width="100">Date</th>
                    <th align="right" width="60">Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(purchase, index) in purchases" :key="index">
                    <td align="left">
                        <button class="btn btn-sm" @click.prevent="deletePurchase(purchase.id)">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                    
                    <td align="left">{{ purchase.description }}</td>
                    <td align="left">{{ purchase.created_at | date }}</td>
                    <td align="right">{{ purchase.amount | currency }}</td>
                </tr>

                <tr>
                    <th colspan="3" align="right">Total</th>
                    <th align="right">{{ total | currency }}</th>
                </tr>
            </tbody>
        </table>
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
