<template>
    <div class="flex flex-wrap" v-if="stats">
        <div class="md:w-1/4 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Income</span>
            <span class="inline-block w-full text-3xl">{{ stats.income | currency }}</span>
        </div>

        <div class="md:w-1/4 mx-auto text-center">
            <span class="inline-block w-full text-base text-grey-lightest">Goal &middot; {{ goalCompletion }}%</span>
            <span class="inline-block w-full text-3xl" @click="startChangingGoal">
                <span v-if="!changingGoal">{{ goalAmount | currency }}</span>
                <span v-if="changingGoal"><input v-model="stats.goal" @blur="changeGoal"></span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stats: null,
                changingGoal: false
            };
        },

        computed: {
            goalCompletion() {
                if (!this.stats.goal || !this.stats.income) {
                    return 0;
                }

                return Math.ceil((this.stats.income / this.stats.goal) * 100);
            },

            goalAmount() {
                return this.stats.goal ? this.stats.goal : 0;
            }
        },

        methods: {
            fetch() {
                ajax.get('/api/summary')
                    .then(r => this.stats = r.data);
            },

            startChangingGoal() {
                this.changingGoal = true;
            },

            changeGoal() {
                ajax.put('/api/goal', { amount: this.stats.goal })
                    .then(r => {
                        this.changingGoal = false;
                    });
            }
        },

        created() {
            this.fetch();

            EventBus.listen('WeekSaved', this.fetch);
        }
    }
</script>