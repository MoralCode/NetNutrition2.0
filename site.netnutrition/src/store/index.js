import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export const store = new Vuex.Store({
    state:{
        APIToken:'',
        foodLog:[],
        diningCenterData:{
            loading:true,
            diningCenters:[],
            diningCenterMenus:{},
        },
        selectedDate:new Date(),
        selectedDiningCenter:undefined,
        selectedMeal:undefined,
    },
    mutations: {
        addToFoodLog(state, foods){
            state.foodLog = state.foodLog.concat(foods)
        },
        updateDiningCenterData(state, data){
            state.diningCenterData.loading = false
            state.diningCenterData.diningCenters = data
        },
        updateDiningCenterMenu(state,payload){
            Vue.set(state.diningCenterData.diningCenterMenus,payload.name, payload.data)
        },
        updateAPIToken(state,token){
            state.APIToken = token
        },
        setDate(state, date){
            state.selectedDate = date;
        },
        setSelectedDiningCenter(state,diningCenter){
            state.selectedDiningCenter = diningCenter
        },
        setSelectedMeal(state, meal){
            state.selectedMeal = meal
        }
    },
    actions:{
        getDiningCenterData({ commit }){
            axios.get(process.env.API_DOMAIN + '/dining-center', {params:{token:store.state.APIToken}})
                    .then(response => {
                        
                        store.commit('updateDiningCenterData', response.data)
                    })
        },

       
        //fetches the foods currently being served at a dining center
        fetchDiningCenterMenu({ commit }, name){
            //find the repesctive id of the dining center, needed for api call
            if(!name)return;
            let id = store.state.diningCenterData.diningCenters.find((elem) => {return elem.name === name}).id;

            if(store.state.diningCenterData.diningCenterMenus[name]){
                store.state.selectedMenu = store.state.diningCenterData.diningCenterMenus[name];
                store.state.selectedDiningCenter = name;
                return;
            }
            //api call
            axios.get(process.env.API_DOMAIN + '/dining-center/' + id + "/view-food-options", {params:{token:store.state.APIToken}})
                    .then(response => {
                        var menuData = {}
                         //transform data into nested dictionary for easy peasy parsing
                        for (let menu of response.data.menus){
                            if (!(menu.name in menuData)){
                                menuData[menu.name] = {}
                            }
                            if (!(menu.station.name in menuData[menu.name])){
                                 menuData[menu.name][menu.station.name] = {}
                            }
                            
                            //transform foods array into dictionary
                            var foods = menu.foods.reduce((foodDict, food) => {
                                    //transform nutrition array into dictionary
                                    foodDict[food.name] = food.nutritions.reduce((nutritionDict, stat) => {
                                        nutritionDict[stat.name] = stat.value
                                        return nutritionDict
                                    }, {})
                                    return foodDict
                            }, {})

                            menuData[menu.name][menu.station.name] = foods
                        }

                        store.state.selectedMenu = menuData;
                        store.state.selectedDiningCenter = name;
                        store.commit('updateDiningCenterMenu', {name:name, data:menuData})
                      
                    })
        }
    },
    getters:{
      
    }
})