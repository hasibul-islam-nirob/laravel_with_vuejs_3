import {createRouter, createWebHistory} from 'vue-router';

import invoiceIndex from '../Components/invoice/index.vue';
import notFound from '../Components/notFound.vue';

const routes = [
    {
        path: '/',
        component: invoiceIndex
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;