
require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

Vue.component('app', require('./app.vue'));

import DiningCentersPage from './components/DiningCentersPage.vue';
import FoodLogPage from './components/FoodLogPage.vue';

Vue.component('dining-centers-page', DiningCentersPage)
Vue.component('food-log-page', FoodLogPage)

const routes = [
  { path: '/dining-centers', component: DiningCentersPage },
  { path: '/food-log', component: FoodLogPage },

]


const router = new VueRouter({
  routes // short for `routes: routes`
})


const app = new Vue({
  router
}).$mount('#app')

