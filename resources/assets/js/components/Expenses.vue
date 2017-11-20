<template>
    <div>
        <button class="btn float-right mb-4 text-xs" @click.prevent="addExpense">
            Add Expense
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th align="left" width="30"></th>
                    <th align="left">Description</th>
                    <th align="right" width="60">Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(item, index) in items" :key="index">
                    <td align="left">
                        <button class="btn btn-sm" @click.prevent="deleteExpense(item.id)">
                            <i class="material-icons">delete</i>
                        </button>
                    </td>
                    
                    <td align="left">{{ item.description }}</td>
                    <td align="right">{{ item.amount | currency }}</td>
                </tr>

                <tr>
                    <th colspan="2" align="right">Total</th>
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
                items: []
            };
        },

        computed: {
            total() {
                let value = 0;

                for (let item of this.items) {
                    value += item.amount;
                }

                return value;
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/expenses')
                    .then(r => this.items = r.data);
            },

            addExpense() {
                let description = prompt('Description');

                if (description !== null) {
                    let amount = prompt('Amount');

                    if (amount !== null) {
                        ajax.post('/api/expenses', { description, amount })
                            .then(this.fetch);
                    }
                }
            },

            deleteExpense(id) {
                ajax.delete(`/api/expenses/${id}`)
                    .then(this.fetch);
            }
        },

        created() {
            this.fetch();
        }
    }
</script>
