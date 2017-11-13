<template>
    <div class="flex flex-wrap">
        <div class="md:w-1/3 text-left">
            Search by date
        </div>

        <div class="md:w-1/3 text-center">
            Title
        </div>

        <div class="md:w-1/3 text-right">
            <button class="btn">Add Row</button>
            <button class="btn">&lt;</button>
            <button class="btn">&gt;</button>
        </div>

        <div class="md:w-full mt-4" v-if="loaded">
            <table class="table">
                <thead>
                    <tr>
                        <th align="left">Description</th>
                        <th align="right" width="60">Rate</th>
                        <th align="right" width="60" v-for="day in days" v-text="day"></th>
                        <th align="right">Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in week.items">
                        <td align="left"><input v-model="item.title" placeholder="Description"></td>
                        <td align="right" width="60"><input v-model="item.rate" placeholder="Rate"></td>
                        <td align="right" width="60" v-for="day in days"><input v-model="item[day.toLowerCase()]" placeholder="Hours"></td>
                        <td align="right"></td>
                    </tr>
                </tbody>
            </table>

            <div class="md:w-full text-right mt-4">
                <button class="btn" @click.prevent="save">Save Changes</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                week: {
                    ending: moment().format('D-M-YYYY'),
                    items: [{
                        title: '',
                        rate: 0,
                        sun: 0,
                        mon: 0,
                        tue: 0,
                        wed: 0,
                        thu: 0,
                        fri: 0,
                        sat: 0,
                    }],
                },
            };
        },

        computed: {
            loaded() {
                return this.week !== null;
            }
        },

        methods: {
            fetch() {
                ajax.get(`/api/weeks/${this.week.ending}`)
                    .then(r => {
                        this.week = r.data;
                    });
            },

            save() {
                ajax.post(`/api/weeks`, this.week)
                    .then(r => {
                        //
                    });
            }
        },

        created() {
            this.fetch();
        }
    }
</script>
