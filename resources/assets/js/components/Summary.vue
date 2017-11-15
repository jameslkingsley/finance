<template>
    <div class="flex flex-wrap" v-if="stats">
        <div class="md:w-1/4 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Income</span>
            <span class="inline-block w-full text-3xl">{{ stats.income | currency }}</span>
        </div>

        <div class="md:w-1/4 mx-auto text-center" v-if="stats.goal">
            <span class="inline-block w-full text-base text-grey-lightest">Goal &middot; {{ goalCompletion }}%</span>
            <span class="inline-block w-full text-3xl">{{ stats.goal | currency }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stats: null
            };
        },

        computed: {
            goalCompletion() {
                if (!this.stats.goal || !this.stats.income) {
                    return 0;
                }

                return Math.ceil((this.stats.income / this.stats.goal) * 100);
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/summary')
                    .then(r => this.stats = r.data);
            }
        },

        created() {
            this.fetch();

            EventBus.listen('WeekSaved', this.fetch);
        }
    }
</script>
