<template>
    <header class="header">
        <div class="header-wrap">
            <button type="button" class="menu-bar">
                <i class="far fa-bars"></i>
            </button>
            <h1 class="logo" v-if="headerData['logo']">
                <a href="/">
                    <img :src="headerData['logo']" alt="">
                </a>
            </h1>
            <div class="search-wrap">
                <input autocomplete="off" title="" autofocus placeholder=""/>
                <button aria-label="search-button" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <div class="header-drop">
            <div class="nav-overlay"></div>
            <nav class="nav-wrap">
                <button class="menu-bar-close">
                    <i class="fal fa-times"></i>
                </button>
                <div class="nav-left">
                    <div class="nav-title">
                        <i class="far fa-bars"></i>
                        Products
                    </div>
                    <ol class="nav-list" v-if="store.layoutData.ready">
                        <li v-for="category in computedCategories"
                            :class="{'menu-item': 1, 'has-children': category['subs'].length}">
                            <a href="#">
                                <img :src="category['icon']" alt=""/>
                                <span>
                                    {{category['title']}}
                                </span>
                                <button type="button" class="btn-sub" v-if="category['subs'].length">
                                    <i class="fal fa-fw fa-angle-down"></i>
                                </button>
                            </a>
                            <ul class="sub-menu" v-if="category['subs'].length">
                                <li v-for="sub in category['subs']"
                                    class="menu-item">
                                    <a href="#">
                                        <span>{{ sub['title'] }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
                <div class="nav-right">
                    <ol class="navigation-deal">
                        <li>
                            <a target="_blank" href="#">Rẻ vô cực - đồng giá 11k</a>
                        </li>
                        <li>
                            <a target="_blank" href="#">Samsung day -33%</a>
                        </li>
                        <li>
                            <a target="_blank" href="#">Flash Sale - Deal 50%</a>
                        </li>
                    </ol>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    name: "index",
}
</script>

<script setup>
import {useLayoutStore} from "@/stores";
import {computed} from "vue";

const store = useLayoutStore();

const headerData = computed(() => store.layoutData.headerData);

const computedCategories = computed(() => headerData.value['menuItems'])
</script>

<style scoped>

</style>
