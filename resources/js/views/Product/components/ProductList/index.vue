<template>
    <ul class="product-wrap">
        <transition-group name="fade-transform">
            <li class="product-item" v-for="item in computedItems" :key="item.id">
                <a target="_blank">
                    <span class="offer-icon" v-if="item['featured']">Đề xuất</span>
                    <div class="product-item-content">
                    <span class="product-img">
                        <img :src="item.image" :alt="item.title">
                    </span>
                        <span class="product-action">To seller</span>
                        <h3>{{ item.title }}</h3>
                        <span class="product-meta">
                        <span class="product-price">{{ store.formatMoney(item.price) }}</span>
                        <span class="product-percent">-27 %</span>
                    </span>
                        <span class="product-shipping blue-light">
                        <i class="ico-happy-smiley"></i>
                        Mua ở đây hỗ trợ trả góp
                    </span>
                    </div>
                    <span class="product-bottom">
                    <span class="product-store"></span>
                    <span class="product-store-logo">
                        <img :src="item['seller_image']">
                    </span>
                </span>
                </a>
            </li>
        </transition-group>
    </ul>
</template>

<script>
export default {
    name: "index.vue"
}
</script>

<script setup>
import {computed} from "vue";
import {useLayoutStore} from "@/stores";

const store = useLayoutStore();

const props = defineProps({
    items: {
        type: Array,
        required: true,
        default: function () {
            return Array()
        }
    }
})

const computedItems = computed(() => {
    return props.items
})
</script>

<style scoped>

</style>
