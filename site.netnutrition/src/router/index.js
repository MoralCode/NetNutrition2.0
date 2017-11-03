import Vue from 'vue'
import Router from 'vue-router'

import HomePage from '@/components/HomePage'
import FoodPage from '@/components/FoodPage.vue';
import FoodLogPage from '@/components/FoodLogPage'
import Stats from '@/components/Stats.vue';

Vue.use(Router)

export default new Router({
  routes:  [
    { path: '/', component: HomePage },
    { path: '/dining-center', component: FoodPage},
    { path: '/dining-center/:location', component: FoodPage },
    { path: '/food-log', component: FoodLogPage },
    { path: '/stats', component: Stats}
  ]
})
