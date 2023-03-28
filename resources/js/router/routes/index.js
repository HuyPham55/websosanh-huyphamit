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
        ]
    },

];

export default routes
