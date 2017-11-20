<template>
    <div>
        <span class="text-left uppercase font-semibold w-full text-sm text-grey-lightest">
            Monthly Expenses
            <a class="float-right text-grey-lightest opacity-50	hover:underline cursor-pointer" @click.prevent="addExpense">New Expense</a>
        </span>

        <div class="card p-0 w-full mt-2">
            <div class="p-4" v-show="!items.length">
                <span class="text-grey-lightest text-base">
                    No expenses each month
                </span>
            </div>

            <div class="list pt-2" v-show="items.length">
                <div class="list-item" v-for="(item, index) in items" :key="index">
                    <span class="list-item-title">
                        {{ item.description }}<br />

                        <small>
                            <a @click.prevent="deleteExpense(item.id)">Delete</a>
                        </small>
                    </span>

                    <span class="list-item-amount">{{ item.amount | currency }}</span>
                </div>

                <div class="list-item list-item-standout">
                    <span class="list-item-title">
                        Total<br />
                        <small>{{ items.length }} expenses</small>
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
                            .then(r => {
                                this.fetch();
                                EventBus.fire('Updated');
                            });
                    }
                }
            },

            deleteExpense(id) {
                ajax.delete(`/api/expenses/${id}`)
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
