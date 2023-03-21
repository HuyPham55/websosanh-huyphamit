<template>
    <select ref="_default">
        <slot></slot>
    </select>
</template>

<script setup>
import {onMounted, onUnmounted, ref, watch} from "vue";

const _default = ref(null);
const props = defineProps({
    options: {
        required: true,
    },
    modelValue: {}
});
const emit = defineEmits(["update:modelValue", 'change'])

onMounted(() => {
    $(_default.value)
        .select2({
            theme: "classic",
            data: props.options
        })
        .val(props.modelValue)
        //Set pre-selected option
        .on("change", function () {
            let selectedValue = this.value;
            emit('update:modelValue', selectedValue)
        })
        .trigger("change")
});

onUnmounted(() => {
    $(_default.value)
        .off()
        .select2("destroy");
})

watch(() => props.options, () => {
    //Reinitialize if props.options changes
    $(_default.value)
        .empty()
        .select2({
            theme: "classic",
            data: props.options
        })
})
watch(() => props.modelValue, (newValue) => {
    $(_default.value)
        .val(newValue)
        .trigger('change');
})
</script>

<!--16/11/2022-->

<!--About
  jQuery Select2 wrapper component for Vue
-->

<!--Requirements
  jQuery
  select2.js
  select2.css
-->

<!--Usage
  <Select2Vue :options="optionList" v-model="selectedValue"/>

  options is an array of object {id, key}

  let item = {id, text}
  options.push(item)
-->


