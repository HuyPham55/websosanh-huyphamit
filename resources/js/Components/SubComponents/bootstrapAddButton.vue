<template>
    <button type="button"
            :class="['btn m-3', isDisabled?'btn-danger':'btn-primary']"
            @click="clickHandler()"
            :disabled="isDisabled">
        <i class="fas fa-plus"></i>
        <slot>&nbsp Add</slot>
    </button>
</template>

<script>
export default {
    name: "bootstrapAddButton",
    emits: {
        click: null,
    },
    props: {
        isDisabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
        }
    },
    methods: {
        clickHandler: function () {
            this.$emit('click'); //always
        },
    }
}
</script>

<style scoped>
button:not([disabled]):hover i {
    transform: rotate(360deg);
    transition: 0.6s;
}

@keyframes shake {
    10%,
    90% {
        transform: translate3d(-1px, 0, 0);
    }

    20%,
    80% {
        transform: translate3d(2px, 0, 0);
    }

    30%,
    50%,
    70% {
        transform: translate3d(-4px, 0, 0);
    }

    40%,
    60% {
        transform: translate3d(4px, 0, 0);
    }
}

.shake {
    animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
    transform: translate3d(0, 0, 0);
    backface-visibility: hidden;
    perspective: 1000px;
}
</style>
