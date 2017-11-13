import Vue from 'vue'
import Router from 'vue-router'

import HomePage from '@/components/HomePage'
import FoodPage from '@/components/FoodPage.vue';
import FoodLogPage from '@/components/FoodLogPage.vue'
import LoginPage from  '@/components/LoginPage.vue'

Vue.use(Router)

export default new Router({
  routes:  [
    { path: '/home', component: HomePage },
    { path: '/dining-center', component: FoodPage},
    { path: '/dining-center/:location', component: FoodPage },
    { path: '/food-log/:date', component: FoodLogPage },
    { path: '/food-log', component: FoodLogPage },
    { path: '/login', component: LoginPage },
  ]
})
