<template>
    <footer v-if="ready">
        <div class="partner swiper-container" v-if="computedSlides">
            <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="slide in computedSlides">
                    <a href="#" class="item-partner" :title="slide['text_1']">
                        <img :src="slide.image" :alt="slide['text_1']">
                    </a>
                </div>
            </div>
            <div class="nav-swiper swiper-button-next"></div>
            <div class="nav-swiper swiper-button-prev"></div>
        </div>
        <div class="footer-container">
            <div class="footer-logo" v-if="footerData['logo']">
                <a href="/">
                    <img :src="footerData['logo']" alt=""/>
                </a>
            </div>
            <div class="company-info">
                <h3 class="tt-footer-box">{{ store.layoutData.title }}</h3>
                <ul class="list-info">
                    <li v-if="footerData['contact_address']">
                        <i class="fas fa-map-marker-alt"></i>
                        Address: {{ footerData['contact_address'] }}
                    </li>
                    <li v-if="footerData['contact_hotline']">
                        <i class="fas fa-phone-alt"></i>
                        Hotline: <a :href="`tel:${footerData['contact_hotline']}`">
                        {{ footerData["contact_hotline"] }}
                    </a>
                    </li>
                    <li v-if="footerData['contact_email']">
                        <i class="fas fa-envelope"></i>
                        Email: <a :href="`mailto:${footerData['contact_email']}`">
                        {{ footerData['contact_email'] }}
                    </a>
                    </li>
                </ul>
            </div>
            <div class="footer-links">
                <h3 class="tt-footer-box">LIÊN KẾT</h3>
                <ol>
                    <li>
                        <a href="#">Chính sách bảo mật</a>
                    </li>
                    <li>
                        <a href="#">Khiếu nại</a>
                    </li>
                    <li>
                        <a href="">Giới thiệu</a>
                    </li>
                    <li>
                        <a href="#">Tin tức</a>
                    </li>
                </ol>
            </div>
        </div>
        <p class="copyright">Copyright © 2023 - All rights reserved</p>
    </footer>
</template>

<script>
export default {
    name: "index"
}
</script>
<script setup>
import {computed, nextTick, onMounted, watch} from "vue";
import {useLayoutStore} from "@/stores";

const store = useLayoutStore()

let computedSlides = computed(() => {
    return store.layoutData.footerData['slides'];
})


let ready = computed(() => {
    return store.layoutData.ready
})

const footerData = computed(() => store.layoutData.footerData)

watch(ready, (newValue, oldValue) => {
    if (ready.value) {
        nextTick(() => {
            initializeSwiper();
        })
    }
}, {immediate: true})

let initializeSwiper = () => {
    const swiper = new Swiper('.partner', {
        slidesPerView: 5,
        spaceBetween: 30,
        autoplay: {
            delay: 5000,
        },
        speed: 1000,
        loop: true,
        preloadImages: false,
        lazy: true,
        // Navigation arrows
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        // Responsive breakpoints
        breakpoints: {
            // when window width is <= 480px
            480: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            // when window width is <= 640px
            640: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
            // when window width is <= 768px
            768: {
                slidesPerView: 4,
                spaceBetween: 10,
            },
            // when window width is <= 960px
            960: {
                spaceBetween: 10,
            }
        }
    });
}
</script>
<style scoped>

</style>
