<template>
    <div class="flex flex-col items-center">
        <f-user-settings-profile :user="user"></f-user-settings-profile>
        <f-user-settings-income :user="user"></f-user-settings-income>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object
        },

        data() {
            return {
                //
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
