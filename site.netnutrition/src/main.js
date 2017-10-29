import axios from 'axios'

import Vue from 'vue'
import router from './router'
import {store} from './store'

//
import Datepicker from 'vuejs-datepicker';
import Accordion from 'vue-strap/src/Accordion.vue' 
import Panel from 'vue-strap/src/Panel.vue' 

//import components
import App from './App.vue' //'root' component
import FoodPage from './components/FoodPage.vue';
import FoodLogPage from './components/FoodLogPage.vue';
import HomePage from './components/HomePage.vue';
import AddFood from './components/AddFood.vue';
import NavBar from './components/NavBar.vue';
import FoodLogView from './components/FoodLogView.vue';
import DatePickerComp from './components/DatePicker.vue';
import DiningCenterSelect from './components/DiningCenterSelect.vue';
import NutritionLabel from './components/NutritionLabel.vue';
import SelectedFood from './components/SelectedFood.vue'

//register components
Vue.component('app-add-food', AddFood)
Vue.component('app', App);
Vue.component('app-nav-bar', NavBar)
Vue.component('app-food-log-view', FoodLogView)
Vue.component('app-date-picker', DatePickerComp);
Vue.component('datepicker', Datepicker);
Vue.component('app-dining-center-select', DiningCenterSelect);
Vue.component('app-nutrition-label',NutritionLabel);
Vue.component('app-selected-food', SelectedFood)




/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App)
})
