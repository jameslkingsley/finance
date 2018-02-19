<template>
    <transition name="fade">
        <div class="fixed pin modal-bg z-50" v-show="visible">
            <transition name="slide-fade">
                <div :class="{ 'w-screen-1/3': !small, 'w-screen-1/4': small }" class="mx-auto mt-12 bg-white text-black rounded modal-shadow" v-show="visible">
                    <div class="border-b border-off-white py-4 px-6 font-semibold text-sm uppercase rounded-t">
                        {{ title }}
                    </div>

                    <div class="p-6 text-lg">
                        <slot></slot>
                    </div>

                    <div class="py-4 px-6 border-t border-off-white rounded-b text-right">
                        <button v-if="textClose !== false" class="text-grey-lightest font-semibold uppercase no-underline text-xs p-2 pb-1 no-outline" @click.prevent="close">
                            {{ textClose }}
                        </button>

                        <button v-if="textComplete !== false" class="btn ml-2" @click.prevent="complete">
                            {{ textComplete }}
                        </button>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            title: String,
            show: { type: Boolean, default: false },
            small: { type: Boolean, default: false },
            textClose: { type: [Boolean, String], default: 'Cancel' },
            textComplete: { type: [Boolean, String], default: 'Complete' }
        },

        data() {
            return {
                visible: this.show
            };
        },

        watch: {
            show(newValue, oldValue) {
                this.visible = newValue;
            }
        },

        methods: {
            complete() {
                this.$emit('complete');
            },

            close() {
                this.visible = false;
                this.$emit('close');
            },

            closeByBackdrop() {
                this.visible = false;
                this.$emit('close');
            }
        }
    };
</script>

<style scoped lang="scss">
    .modal-bg {
        background-color: rgba(82, 95, 127, 0.25);
    }

    .modal-shadow {
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.07),
            0 2px 15px rgba(84, 96, 103, 0.25);
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity 0.3s ease;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .slide-fade-enter-active {
        transition: all 0.3s ease;
    }

    .slide-fade-leave-active {
        transition: all 0.3s ease;
    }

    .slide-fade-enter,
    .slide-fade-leave-to {
        transform: translateY(-10rem);
        opacity: 0;
    }
</style>
