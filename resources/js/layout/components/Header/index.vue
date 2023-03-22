<template>
    <header class="header">
        <div class="header-wrap">
            <button type="button" class="menu-bar">
                <i class="far fa-bars"></i>
            </button>
            <h1 class="logo">
                <a href="/">
                    <img src="/images/logo.svg" alt="">
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
                    <ol class="nav-list">
                        <li class="menu-item">
                            <a href="#">
                                <img src="/images/cate-dien-lanh.svg"/>
                                <span>Category 1</span>
                            </a>
                        </li>
                        <li class="menu-item has-children">
                            <a href="#">
                                <img src="/images/cate-dien-thoai-may-tinh-bang.svg"/>
                                <span>Category 2</span>
                                <button type="button" class="btn-sub">
                                    <i class="fal fa-fw fa-angle-down"></i>
                                </button>
                            </a>
                            <ul class="sub-menu">
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 2.1</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 2.2</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 2.3</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 2.4</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 2.5</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item has-children">
                            <a href="#">
                                <img src="/images/cate-do-gia-dung.svg"/>
                                <span>Category 3</span>
                                <button type="button" class="btn-sub">
                                    <i class="fal fa-fw fa-angle-down"></i>
                                </button>
                            </a>
                            <ul class="sub-menu">
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 3.1</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 3.2</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 3.3</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 3.4</span>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="#">
                                        <span>Category 3.5</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="#">
                                <img src="/images/cate-thiet-bi-van-phong.svg"/>
                                <span>Category 4</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#">
                                <img src="/images/cate-thiet-bi-y-te-suc-khoe.svg"/>
                                <span>Category 5</span>
                            </a>
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

<style scoped>

</style>
