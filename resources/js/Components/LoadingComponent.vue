<template>
    <div :class="{'preloader': 1, 'inactive': useClass && ready}">
        <div class="clear-loading loading-effect" v-if="useCircle">
            <img src="/images/loading.svg" alt=""/>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoadingComponent"
}
</script>

<script setup>
const props = defineProps({
    position: {
        default: 'fixed',
    },
    width: {
        default: 'unset'
    },
    height: {

    },
    top: {
      default: 0
    },
    useCircle: {
        default: true
    },
    zIndex: {
        default: 999
    },
    useClass: {
        default: false,
    },
    ready: {
        default: false,
    },
    duration: {
        default: '0.4s'
    }
})
</script>

<style scoped>

.preloader {
    position: v-bind(position);
    width: v-bind(width);
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: v-bind(zIndex);
    background: rgba(255, 255, 255, .8) 50% 50% no-repeat;
    opacity: 1;
    transition: all v-bind(duration);
    visibility: visible;
}

.preloader.inactive {
    opacity: 0;
    visibility: hidden;
}

.preloader > div {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.preloader > div > img {
    max-width: 100px;
    max-height: 100px;
}
</style>
