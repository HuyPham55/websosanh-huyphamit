<template>
    <div class="article-related" v-show="items.length">
        <h5>News</h5>
        <div class="article-related-wrap swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="item in items">
                    <a href="">
                        <span class="article-related-img">
                            <img :src="item.image">
                        </span>
                        <h3>{{ item.title }}</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewsSlider"
}
</script>

<script setup>
import {nextTick, onMounted, watch} from "vue";

const props = defineProps({
    items: {
        required: true,
    },
    ready: {
        required: true,
        default: false,
    }
})

watch(() => props.ready, function() {
    if (props.ready) {
        nextTick(initializeSlider);
    }
}, {immediate: true})

function initializeSlider() {
    var articleRelated = new Swiper('.article-related-wrap', {
        slidesPerView: 3,
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

onMounted(() => {
})
</script>

<style scoped>

</style>
