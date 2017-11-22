<template>
    <div class="w-full">
        <span class="text-left uppercase font-semibold w-full text-sm text-grey-lightest">
            This Week's Work &middot;
            <span class="hidden md:inline-block">{{ title }}</span>
            <span class="inline-block md:hidden">{{ week.ending | date }}</span>
            <a class="float-right text-grey-lightest opacity-50 hover:underline cursor-pointer pl-2" @click.prevent="nextWeek">&gt;</a>
            <a class="float-right text-grey-lightest opacity-50 hover:underline cursor-pointer px-2" @click.prevent="previousWeek">&lt;</a>
            <a class="float-right text-grey-lightest opacity-50 hover:underline cursor-pointer mr-1" @click.prevent="addRow">New Row</a>
        </span>

        <div class="card w-full mb-8 mt-2 md:p-4 p-2">
            <div class="flex flex-wrap">
                <div class="w-full">
                    <table class="table -mt-2">
                        <thead>
                            <tr>
                                <th align="left" class="hidden md:table-cell">Description</th>
                                <th align="left" width="30" class="hidden md:table-cell"></th>
                                <th align="right" width="60" class="text-left md:text-right">Rate</th>
                                <th align="right" width="60" v-for="(day, index) in days" :key="index" v-text="day"></th>
                                <th align="right" width="75" class="hidden md:table-cell">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(item, index) in week.items" :key="index">
                                <td align="left" class="hidden md:table-cell">
                                    <input v-model="item.title" placeholder="Description">
                                </td>

                                <td align="left" class="hidden md:table-cell">
                                    <a @click.prevent="deleteRow(index)" class="text-xs text-grey-lightest hover:underline cursor-pointer">Delete</a>
                                </td>

                                <td align="right" width="60" class="text-left md:text-right">
                                    <input v-model="item.rate" @focus="$event.target.select()" placeholder="Rate">
                                </td>

                                <td align="right" width="60" v-for="(day, index) in days" :key="index">
                                    <input @focus="$event.target.select()" v-model="item[day.toLowerCase()]" placeholder="Hours">
                                </td>

                                <td align="right" class="hidden md:table-cell">
                                    {{ getTotal(index) | currency }}
                                </td>
                            </tr>

                            <tr>
                                <th colspan="10" align="right" class="hidden md:table-cell">Weekly Total</th>
                                <th colspan="7" align="right" class="table-cell md:hidden">Weekly Total</th>
                                <th align="right">{{ weekTotal | currency }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="w-full text-right mt-2">
                    <button class="btn btn-primary" @click.prevent="save">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Toasted from 'vue-toasted';
    import Datepicker from 'vuejs-datepicker';

    Vue.use(Toasted);

    export default {
        components: { Toasted, Datepicker },

        data() {
            return {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                week: {
                    ending: moment().day('Saturday'),
                    items: []
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
                    sat: null
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
                ajax
                    .get(`/api/weeks/${this.week.ending.format('D-M-YYYY')}`)
                    .then(r => {
                        this.week = r.data;
                    })
                    .catch(e => {
                        this.week.items = [this.defaultItem];
                    });
            },

            save() {
                ajax.post(`/api/weeks`, this.week).then(r => {
                    EventBus.fire('Updated');
                    this.$toasted.show('Changes Saved', {
                        theme: 'bubble',
                        position: 'top-center',
                        duration: 2000
                    });
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
                    sat: null
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
    };
</script>
