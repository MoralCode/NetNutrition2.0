import Vue from 'vue'
import Router from 'vue-router'

import HomePage from '@/components/HomePage'
import AddFoodPage from '@/components/AddFoodPage.vue';
import FoodLogPage from '@/components/FoodLogPage.vue'
import LoginPage from  '@/components/LoginPage.vue';
import Stats from '@/components/Stats.vue';
import Admin from '@/components/Admin.vue';

Vue.use(Router)

export default new Router({
  routes:  [
    { path: '/home', component: HomePage },
    { path: '/dining-center', component: AddFoodPage},
    { path: '/dining-center/:location', component: AddFoodPage },
    { path: '/food-log/:date', component: FoodLogPage },
    { path: '/food-log', component: FoodLogPage },
    { path: '/stats', component: Stats},
    { path: '/login', component: LoginPage },
    { path: '/admin', component: Admin}
  ]
})
