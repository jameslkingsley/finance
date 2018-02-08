<template>
    <div :class="classes" :style="styles">
        <div class="screen">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            shadow: { type: Boolean, default: false },
            width: { type: String, default: '440px' },
            height: { type: String, default: '900px' }
        },

        computed: {
            classes() {
                return {
                    mobile: true,
                    shadow: this.shadow
                };
            },

            styles() {
                return {
                    width: this.width,
                    height: this.height
                };
            }
        }
    };
</script>

<style lang="scss">
    .mobile {
        height: 900px;
        border-radius: 65px;
        position: relative;
        width: 440px;
        top: auto;
        left: 0;
        z-index: auto;
        background: linear-gradient(to bottom left, #f3f8fb, #e5ebf2);
        opacity: 1;
        transition: none;
        pointer-events: auto;

        &.shadow {
            box-shadow: inset 6px -6px 15px rgba(145, 160, 180, 0.45),
                -30px 30px 40px rgba(118, 146, 180, 0.18);

            .screen {
                box-shadow: -1px 1px 6px rgba(170, 183, 204, 0.2);
            }
        }

        &::before {
            width: 76px;
            height: 8px;
            left: 182px;
            top: 54px;
            border-radius: 4px;
            background: #e4eaf1;
            content: '';
            position: absolute;
        }

        &::after {
            width: 70px;
            height: 70px;
            left: 185px;
            bottom: 18px;
            border-radius: 35px;
            background: #dde3eb;
            content: '';
            position: absolute;
        }

        .screen {
            position: relative;
            width: 88%;
            height: 76%;
            border-radius: 6px;
            background: linear-gradient(#f6f9fc 70%, #fff);
            overflow: hidden;
            left: 0;
            top: 12%;
            margin: 0 auto;
            transform: none;

            iframe {
                width: 100%;
                height: 100%;
                border: none;
            }

            div {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }
        }
    }
</style>
