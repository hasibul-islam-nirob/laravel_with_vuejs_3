import {createRouter, createWebHistory} from 'vue-router';

import invoiceIndex from '../Components/invoice/index.vue';
import notFound from '../Components/notFound.vue';
import addNewForm from '../Components/invoice/new.vue';

const routes = [
    {
        path: '/',
        component: invoiceIndex
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    },
    {
        path:'/invoice/new',
        component: addNewForm
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;