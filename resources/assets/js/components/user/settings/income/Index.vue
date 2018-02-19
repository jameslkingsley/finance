<template>
    <div class="card p-0 w-full mb-8 mt-2">
        <div class="card-header">
            Income
        </div>

        <div>
            <grid
                class="py-3 cursor-pointer hover:bg-off-white-3 last:rounded-b"
                :class="{ 'bg-off-white-3': selectedType.id === type.id }"
                auto-rows="min-content"
                template-columns="0.05fr 0.95fr"
                row-gap="1rem"
                v-for="(type, index) in types"
                :key="index"
                @click.native="selectedType = type">
                <div class="text-center pt-3 h-full">
                    <input type="radio" name="type" :checked="selectedType.id === type.id">
                </div>

                <div>
                    <span class="inline-block w-full">{{ type.title }}</span>
                    <span class="inline-block w-full text-sm text-grey-lightest">{{ type.text }}</span>
                </div>

                <grid-child v-show="selectedType.id === type.id" column-start="1" column-end="3" class="border-t border-line py-4 pb-2 text-center">
                    <component :is="type.component" :user="user"></component>
                </grid-child>
            </grid>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object
        },

        data() {
            return {
                // selectedType: optional(),
                selectedType: {
                    id: 'salary',
                    title: 'Salary',
                    component: 'f-user-settings-income-salary',
                    text: "You can specify how much you're paid and how often."
                },
                types: [
                    {
                        id: 'salary',
                        title: 'Salary',
                        component: 'f-user-settings-income-salary',
                        text: "You can specify how much you're paid and how often."
                    },
                    {
                        id: 'wages',
                        title: 'Wages',
                        component: 'f-user-settings-income-wages',
                        text: 'Fill out a time sheet each week with your hours.'
                    }
                ]
            };
        },

        computed: {
            //
        },

        methods: {
            //
        }
    };
</script>
