<template>
    <div class="slider-related swiper-container">
        <div class="swiper-wrapper">
            <div v-for="item in items"
                 class="swiper-slide product-item">
                <a href="#" @click.prevent="productStore.onClick(item)">
                    <span class="product-img">
                        <img :src="item.image"/>
                    </span>
                    <span class="product-action">
                        {{ item.index==='products' ? "To seller" : "Let's compare" }}
                    </span>
                    <h3>{{ item.title }}</h3>
                    <span class="product-meta">
                        <span class="product-price">
                            {{ store.formatMoney(item.price) }}
                        </span>
                    </span>
                    <span class="product-bottom">
                        <span class="product-store">
                            {{ getItemMeta(item) }}
                        </span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductSlider"
}
</script>

<script setup>
import {nextTick, watch} from "vue";
import {useRouter} from "vue-router";
import {useProductStore} from "@/stores";
import {useLayoutStore} from "@/stores";

const store = useLayoutStore();

const productStore = useProductStore();

const props = defineProps({
    items: {
        required: true
    },
    ready: {
        required: true,
        default: false,
    }
})
const router = useRouter();



function getItemMeta(item) {
    return item['products_count']
        ? `${item['products_count']} seller(s)`
        : (item['featured'] ? "Featured" : '')
}


const initializeRelatedSlide = function() {
    let related = new Swiper('.slider-related', {
        slidesPerView: 4,
        spaceBetween: 20,
        autoplay: {
            delay: 4000,
        },
        speed: 1000,
        rewind: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        // Responsive breakpoints
        breakpoints: {

            640: {
                slidesPerView: 2,
                spaceBetween: 10,

            },
            // when window width is <= 768px
            768: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            // when window width is <= 960px
            960: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            // when window width is <= 1080px
            1080: {
                slidesPerView: 4,
                spaceBetween: 10,
            }
        }
    });
}

watch(() => props.ready, (newValue, oldValue) => {
    if (props.ready) {
        nextTick(initializeRelatedSlide)
    }
}, {immediate: true})
</script>

<style scoped>

</style>
