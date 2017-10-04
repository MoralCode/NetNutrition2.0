import Vue from 'vue'
import Router from 'vue-router'

import HomePage from '@/components/HomePage'
import DiningCentersPage from '@/components/DiningCentersPage'
import DiningCenterPage from '@/components/DiningCenterPage'
import FoodLogPage from '@/components/FoodLogPage'

Vue.use(Router)

export default new Router({
  routes:  [
    { path: '/', component: HomePage },
    { path: '/dining-centers', component: DiningCentersPage },
    { path: '/dining-center/:location', component: DiningCenterPage },
    { path: '/food-log', component: FoodLogPage },
  ]
})
