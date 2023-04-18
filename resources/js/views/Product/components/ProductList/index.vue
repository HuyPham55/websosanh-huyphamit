<template>
    <ul class="product-wrap">
        <transition-group name="fade-transform">
            <li class="product-item" v-for="item in computedItems" :key="key(item)">
                <a target="_blank" @click.prevent="clickHandler(item)">
                    <span class="offer-icon" v-if="item['featured']">Featured</span>
                    <div class="product-item-content">
                    <span class="product-img">
                        <img :src="item.image" :alt="item.title"/>
                    </span>
                    <span class="product-action" @click="clickHandler(item)">
                        {{ getItemType(item) === 0 ? "To seller" : "Let's compare" }}
                    </span>
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
                        <img v-if="item['seller_image']" :src="item['seller_image']">
                    </span>
                </span>
                </a>
            </li>
        </transition-group>
    </ul>
    <LoadingComponent
        :useCircle="false"
        :ready="ready"
        :style="preloaderStyle"/>
</template>

<script>
export default {
    name: "index.vue"
}
</script>

<script setup>
import {computed} from "vue";
import {useLayoutStore} from "@/stores";
import {useProductStore} from "@/stores";
import LoadingComponent from "@/Components/LoadingComponent.vue";
import {useRouter} from "vue-router";

const preloaderStyle = {
    width: "-webkit-fill-available",
    position: "absolute",
    transition: "all 0.75",
    'z-index': '1',
}

const router = useRouter();
const store = useLayoutStore();
const productStore = useProductStore();
const itemTypes = {
    'products': 0,
    'comparisons': 1
} //also used in search form, comparison

const getItemType = function(item) {
    //also used in search form, comparison
    let index = item['index'];
    return itemTypes[index]
}

const key = (item) => item.index + item.id;
const props = defineProps({
    items: {
        type: Array,
        required: true,
        default: function () {
            return Array()
        }
    },
    ready: {
        default: true,
    }
})


const computedItems = computed(() => {
    return props.items
})

const clickHandler = function(item) {
    //also used in search form, product list
    let itemType = getItemType(item);
    let id = item.id;
    if (itemType === 0) {
        productStore.getProductUrl(id);
        return;
    }
    if (itemType === 1) {
        router.push({name: 'comparison', params: {id: item.id, slug: item.slug}})
    }
}
</script>

<style scoped>

</style>
