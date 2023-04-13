import Layout from "@/layout/index.vue";
import HomePage from "@/views/HomePage.vue";
const routes = [
    {
        path: '/',
        component: Layout,
        children: [
            {
                path: '',
                name: 'home',
                component: HomePage,
            },
            {
                path: "/product-category/:id/:slug",
                name: 'product_category',
                component: () => import("@/views/Product/Category/index.vue")
            },
            {
                path: "/search",
                name: 'search',
                component: () => import("@/views/Product/Search/index.vue")
            },
            {
                path: "/product/compare/:id/:slug",
                name: 'comparison',
                component: () => import("@/views/Comparison/index.vue")
            },
            {
                path: "/news/:id/:slug",
                name: 'news_detail',
                component: () => import("@/views/News/Detail/index.vue")
            },
        ]
    },

];

export default routes
