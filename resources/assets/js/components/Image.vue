<template>
    <div :style="styles"></div>
</template>

<script>
    export default {
        props: {
            url: String,
            size: { type: String, default: null },
            position: { type: String, default: null }
        },

        computed: {
            styles() {
                return {
                    'background-repeat': 'no-repeat',
                    'background-image': `url(${this.url})`,
                    'background-size': this.size ? this.size : 'cover',
                    'background-position': this.position ? this.position : 'center'
                };
            }
        }
    };
</script>
