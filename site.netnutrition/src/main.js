import axios from 'axios'

import Vue from 'vue'
import router from './router'
import {store} from './store'
import {datepicker} from 'vue-strap'


//import components
import App from './App.vue' //'root' component
import DiningCentersPage from './components/DiningCentersPage.vue';
import FoodPage from './components/FoodPage.vue';
import FoodLogPage from './components/FoodLogPage.vue';
import HomePage from './components/HomePage.vue';
import AddFood from './components/AddFood.vue';
import NavBar from './components/NavBar.vue';
import FoodLogView from './components/FoodLogView.vue';
import DatePickerComp from './components/DatePicker';

//register components
Vue.component('app-add-food', AddFood)
Vue.component('app', App);
Vue.component('app-nav-bar', NavBar)
Vue.component('app-food-log-view', FoodLogView)
Vue.component('app-date-picker', DatePickerComp);
Vue.component('datepicker', datepicker);


/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
})
