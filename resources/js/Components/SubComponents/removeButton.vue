<!--Boot strap compatible remove button-->
<!--This button already has a col wrapper-->
<template>
    <div :class="'d-flex align-items-center col'+(colDivision?`-${colDivision}`:'')">
        <button type="button"
                :class="['btn', buttonClass]"
                :title="label"
                @mouseover.stop="isHover()"
                @mouseleave.stop="isNotHover()"
                @click="$emit('click')">
            {{ isHovered ? hoverLabel : label || 'Remove'}}
            <i class="ti-trash"></i>
        </button>
    </div>
</template>

<script>
export default {
    name: "removeButton",
    emits: {
        click: {},
    },
    props: {
        label: {
            type: String,
            default: 'Remove',
        },
        hoverLabel: {
            type: String,
            default: 'Are you sure?',
        },
        hasData: {},
        colDivision: {
            type: null,
        }
    },
    methods: {
        isHover: function () {
            this.isHovered = true;
        },
        isNotHover: function () {
            this.isHovered = false;
        },
    },

    data: function () {
        return {
            isHovered: false,
        }
    },
    computed: {
        buttonClass: function () {
            if (this.hasData && this.isHovered) {
                return 'btn-danger';
            }
            if (!this.hasData && this.isHovered) {
                return 'btn-warning';
            }
            if (!this.hasData) {
                return 'btn-primary';
            }
            if (this.hasData && !this.isHovered) {
                return 'btn-warning';
            }
        }
    }
}
</script>

<style scoped>
button {

}
</style>
