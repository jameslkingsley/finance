<template>
    <div class="flex flex-wrap">
        <div class="md:w-1/3 text-left">
            <!-- <datepicker placeholder="Search by date" format="dd/MM/yyyy"></datepicker> -->
        </div>

        <div class="md:w-1/3 text-center text-lg font-semibold">
            {{ title }}
        </div>

        <div class="md:w-1/3 text-right">
            <button class="btn mr-3" @click.prevent="addRow">New Row</button>

            <div class="btn-group">
                <button class="btn" @click.prevent="nextWeek">&gt;</button>
                <button class="btn" @click.prevent="previousWeek">&lt;</button>
            </div>
        </div>

        <div class="md:w-full mt-4 pt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th align="left" width="30"></th>
                        <th align="left">Description</th>
                        <th align="right" width="60">Rate</th>
                        <th align="right" width="60" v-for="(day, index) in days" :key="index" v-text="day"></th>
                        <th align="right" width="75">Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(item, index) in week.items" :key="index">
                        <td align="left">
                            <button class="btn btn-sm" @click.prevent="deleteRow(index)">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>

                        <td align="left">
                            <input v-model="item.title" placeholder="Description">
                        </td>

                        <td align="right" width="60">
                            <input v-model="item.rate" @focus="$event.target.select()" placeholder="Rate">
                        </td>

                        <td align="right" width="60" v-for="(day, index) in days" :key="index">
                            <input @focus="$event.target.select()" v-model="item[day.toLowerCase()]" placeholder="Hours">
                        </td>

                        <td align="right">
                            {{ getTotal(index) | currency }}
                        </td>
                    </tr>

                    <tr>
                        <th colspan="10" align="right">Weekly Total</th>
                        <th align="right">{{ weekTotal | currency }}</th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="md:w-full mt-4">
            <div class="md:w-full text-right mt-4">
                <button class="btn btn-primary" @click.prevent="save">Save Changes</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: { Datepicker },

        data() {
            return {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                week: {
                    ending: moment().day('Saturday'),
                    items: [],
                },

                defaultItem: {
                    title: '',
                    rate: null,
                    sun: null,
                    mon: null,
                    tue: null,
                    wed: null,
                    thu: null,
                    fri: null,
                    sat: null,
                }
            };
        },

        computed: {
            loaded() {
                return this.week !== null;
            },

            title() {
                return moment(this.week.ending).format('Do MMMM, YYYY');
            },

            weekTotal() {
                let total = 0;

                for (let i = 0; i < this.week.items.length; i++) {
                    let itemTotal = this.getTotal(i);
                    total += itemTotal;
                }

                return total;
            }
        },

        methods: {
            fetch() {
                ajax.get(`/api/weeks/${this.week.ending.format('D-M-YYYY')}`)
                    .then(r => {
                        this.week = r.data;
                    })
                    .catch(e => {
                        this.week.items = [this.defaultItem];
                    });
            },

            save() {
                ajax.post(`/api/weeks`, this.week)
                    .then(r => {
                        EventBus.fire('Updated');
                    });
            },

            getTotal(index) {
                let total = 0;
                let item = this.week.items[index];

                for (let day of this.days) {
                    total += Number(item[day.toLowerCase()]);
                }

                return total * Number(item.rate);
            },

            addRow() {
                this.week.items.push({
                    title: '',
                    rate: null,
                    sun: null,
                    mon: null,
                    tue: null,
                    wed: null,
                    thu: null,
                    fri: null,
                    sat: null,
                });
            },

            deleteRow(index) {
                this.week.items.splice(index, 1);
            },

            nextWeek() {
                this.week.ending = moment(this.week.ending).add(7, 'days');
                this.fetch();
            },

            previousWeek() {
                this.week.ending = moment(this.week.ending).subtract(7, 'days');
                this.fetch();
            }
        },

        created() {
            this.week.items = [this.defaultItem];

            this.fetch();
        }
    }
</script>
