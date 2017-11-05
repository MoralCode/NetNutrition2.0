import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export const store = new Vuex.Store({
    state:{
        APIToken:'',
        foodLog:{},
        diningCenterData:{
            loading:true,
            diningCenters:[],
            diningCenterMenus:{},
        },
        selectedDate:new Date(),
        selectedDiningCenter:undefined,
        selectedMeal:undefined,
        selectedFoods:{}
    },
    mutations: {
        submitFood(state){
            store.dispatch('postFoodLog')
            store.commit('updateFoodLog', state.selectedFoods)
            state.selectedFoods = {}
            console.log(state.foodLog)
          
        },

        updateFoodLog(state, foodData){
             state.foodLog = {}
             for (let id in  foodData){
                if (!(id in state.foodLog)){
                    Vue.set(state.foodLog, id, foodData[id])
                }
                else {
                    state.foodLog[id].servings += foodData[id].servings
                }
            }
           
            console.log(state.foodLog)
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
        },
        incrementSelectedFood(state,food){
            if (!(food.id in state.selectedFoods)){
                    Vue.set(state.selectedFoods, food.id,  {
                    servings:1,
                    food: food,
                    menu: state.diningCenterData.diningCenterMenus[state.selectedDiningCenter][state.selectedMeal]
                })
            }
            else {
                state.selectedFoods[food.id].servings += 1
            }
            
        },
        decrementSelectedFood(state, food){
            if (!(food.id in state.selectedFoods)){
                return
            }
            else {
                state.selectedFoods[food.id].servings -= 1
                if (state.selectedFoods[food.id].servings <= 0 ){
                     Vue.delete(state.selectedFoods, food.id)
                }
            }
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
            let diningCenter = store.state.diningCenterData.diningCenters.find((elem) => {return elem.name === name});
            if (diningCenter == undefined){
                window.setTimeout(()=>{store.dispatch('fetchDiningCenterMenu',name)}, 1000)
                return
            }
            let id = diningCenter.id

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
                                menuData[menu.name] = {stations:{}}
                                menuData[menu.name]['id'] = menu.id
                            }
                            if (!(menu.station.name in menuData[menu.name])){
                                 menuData[menu.name]['stations'][menu.station.name] = {}
                            }
                            
                            //transform foods array into dictionary
                            var foods = menu.foods.reduce((foodDict, food) => {
                                    //transform nutrition array into dictionary
                                    foodDict[food.name] = food.nutritions.reduce((nutritionDict, stat) => {
                                        nutritionDict[stat.name] = stat.value
                                        return nutritionDict
                                    }, {})
                                    foodDict[food.name]['name'] = food.name
                                    foodDict[food.name]['id'] = food.id
                                    foodDict[food.name]['modal'] = false;
                                    return foodDict
                            }, {})

                            menuData[menu.name]['stations'][menu.station.name] = foods
                         
                        }

                        store.state.selectedMenu = menuData;
                        store.state.selectedDiningCenter = name;
                        store.commit('updateDiningCenterMenu', {name:name, data:menuData})
                      
                    })
        },
        postFoodLog({commit}){

                let foods = []
                let menus = []
                let servings = []

                for (let id in store.state.selectedFoods){
                    let item = store.state.selectedFoods[id]
                    foods.push(item.food.id)
                    menus.push(item.menu.id)
                    servings.push(item.servings)
                }

                let params = {
                    params:{
                        token:store.state.APIToken,
                        foods:foods,
                        menus:menus,
                        servings:servings
                    }                                                   
                }
            
                axios.get(process.env.API_DOMAIN + '/food-log/do/add', params)
                        .then(response => {
                            console.log(response)
                        })
        },
        fetchFoodLog({commit}, date){

             let tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
             let dateString = (new Date(date - tzoffset)).toISOString().split('T')[0]

            let params = {
                params: {
                    token:store.state.APIToken,
                    date: dateString
                }
            }

            axios.get(process.env.API_DOMAIN + '/food-log', params)
                    .then(response => {
                        console.log(response)
                        let foodData = {}
                        console.log(response.data[0])
                        let data = response.data[0]

                        for (let i = 0; i < data.foods.length; i++){
                            let food = data.foods[i]
                            console.log(food)
                            if (food.id in foodData){
                                foodData[food.id].servings += parseInt(food.pivot.servings)
                            }
                            else {
                                foodData[food.id] = {
                                    food: food,
                                    servings: parseInt(food.pivot.servings),
                                    menu: data.menus[i]
                                }
                            }
                        }
                        console.log(foodData)
                        store.commit('updateFoodLog', foodData)
                    })
        }
    },
    getters:{
      
    }
})