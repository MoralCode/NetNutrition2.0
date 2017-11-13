import axios from 'axios'

import Vue from 'vue'
import router from './router'
import {store} from './store'

//
import Datepicker from 'vuejs-datepicker'; 

//import components
import App from './App.vue' //'root' component
import FoodLogPage from './components/FoodLogPage.vue';
import AddFoodPage from './components/AddFoodPage.vue';
import HomePage from './components/HomePage.vue';
import FoodSelect from './components/FoodSelectionList.vue';
import NavBar from './components/NavBar.vue';
import DatePickerComp from './components/DatePicker.vue';
import DiningCenterSelect from './components/DiningCenterSelect.vue';
import NutritionLabel from './components/NutritionLabel.vue';
import Stats from './components/Stats.vue';
import SingleDayStats from './components/SingleDayStats.vue';
import SelectedFood from './components/SelectedFood.vue';
import LoginPage from './components/LoginPage.vue';

//register components
Vue.component('app-food-select-list', FoodSelect)
Vue.component('app', App);
Vue.component('app-nav-bar', NavBar);
Vue.component('app-date-picker', DatePickerComp);
Vue.component('datepicker', Datepicker);
Vue.component('app-dining-center-select', DiningCenterSelect);
Vue.component('app-nutrition-label',NutritionLabel);
Vue.component('app-selected-food', SelectedFood);
Vue.component('app-stats-page', Stats);
Vue.component('app-single-day-stats', SingleDayStats);


/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
})
