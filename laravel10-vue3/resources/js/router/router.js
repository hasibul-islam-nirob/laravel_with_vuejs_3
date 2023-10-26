import {createRouter, createWebHistory} from 'vue-router';

import invoiceIndex from '../Components/invoice/index.vue';
import notFound from '../Components/notFound.vue';
import addNewForm from '../Components/invoice/new.vue';
import showInvoice from '../Components/invoice/show.vue';

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
    },
    {
        path:'/invoice/show/:id',
        component: showInvoice,
        props: true
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;