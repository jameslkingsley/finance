<template>
    <div class="calendar card mb-8 p-0 pb-2">
        <div class="calendar-header">
            <div></div>
            <div class="text-center font-medium opacity-50" v-for="(day, index) in days" :key="index">
                {{ day }}
            </div>
        </div>

        <div class="calendar-rows" v-for="(block, index) in blocks" :key="index">
            <div class="text-center font-medium opacity-50 pl-4 pr-3">{{ block }}</div>
            <div class="calendar-tile" v-for="(day, index) in days" :key="index"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            };
        },

        computed: {
            blocks() {
                let blocks = [];

                for (let i = 60; i < 60 * 25; i += 5) {
                    blocks.push(
                        moment()
                            .minute(i)
                            .format('HH:mm')
                    );
                }

                return blocks;
            },

            blocksChunked() {
                return _.chunk(this.blocks, 7);
            }
        },

        methods: {
            //
        }
    };
</script>
