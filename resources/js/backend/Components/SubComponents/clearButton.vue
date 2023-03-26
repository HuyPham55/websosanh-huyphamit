<template>
    <button type="button"
            :class="['btn m-3', isDisabled?'btn-danger':'btn-outline-danger']"
            @click="clickHandler()"
            :disabled="isDisabled">
        <i class="fas fa-eraser"></i>
        <slot>&nbsp Clear all</slot>
    </button>
</template>

<script>
export default {
    name: "clearButton",
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

</style>
