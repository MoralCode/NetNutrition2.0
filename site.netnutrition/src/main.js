import axios from 'axios'

import Vue from 'vue'
import router from './router'
import {store} from './store'



//import components
import App from './App.vue' //'root' component
import DiningCentersPage from './components/DiningCentersPage.vue';
import FoodPage from './components/FoodPage.vue';
import FoodLogPage from './components/FoodLogPage.vue';
import HomePage from './components/HomePage.vue';
import AddFood from './components/AddFood.vue';
import NavBar from './components/NavBar.vue'
import FoodLogView from './components/FoodLogView.vue'

//register components
Vue.component('app-add-food', AddFood)
Vue.component('app', App);
Vue.component('app-nav-bar', NavBar)
Vue.component('app-food-log-view', FoodLogView)



/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
})
