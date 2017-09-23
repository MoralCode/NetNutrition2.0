
require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('app', require('./app.vue'));

import DiningCentersPage from './components/DiningCentersPage.vue';
import DiningCenterPage from './components/DiningCenterPage.vue';
import FoodLogPage from './components/FoodLogPage.vue';



const routes = [
    { path: '/dining-centers', component: DiningCentersPage },
    { path: '/dining-center/:location', component: DiningCenterPage },
    { path: '/food-log', component: FoodLogPage },
]


const router = new VueRouter({
  routes // short for `routes: routes`
})


const app = new Vue({
  router
}).$mount('#app')

