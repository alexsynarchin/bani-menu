import Layout from "@/admin/js/layout/index.vue";
const catalogRoutes = {
    name: 'catalog',
    path: '/catalog',
    component: Layout,
    meta: { title: 'Каталог',  noCache: false },
    children: [
        {
            name: 'categories',
            path:'',
            component: () => import('@/admin/js/views/category/index'),
            meta: {title: ''}},
        {
            name:'categoryShow',
            path: ':categoryId',
            meta: {title: 'Категория'},
            component: () => import('@/admin/js/views/category/show')
        },

    ]
}

export default catalogRoutes;
