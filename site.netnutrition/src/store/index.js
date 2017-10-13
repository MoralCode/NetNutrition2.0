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
        selectedDate:new Date()
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
            console.log("updating menus", payload.name,payload.data)
            Vue.set(state.diningCenterData.diningCenterMenus,payload.name, payload.data)
            console.log(state.diningCenterData.diningCenterMenus[payload.name])
        },
        updateAPIToken(state,token){
            console.log("token", token)
            state.APIToken = token
        },
        setDate(state, date){
            state.selectedDate = date;
        }
    },
    actions:{
        getDiningCenterData({ commit }){
            console.log("loading dining centers")
            axios.get('http://api.netnutrition.dev/dining-center', {params:{token:store.state.APIToken}})
                    .then(response => {
                        console.log(response)
                        store.commit('updateDiningCenterData', response.data)
                        console.log("dining center data loaded")
                    })
        },

        getDiningCenterMenu({ commit }, name ){
            console.log(name)
            let id = store.state.diningCenterData.diningCenters.find((elem) => {return elem.name == name} ).id
            axios.get('http://api.netnutrition.dev/dining-center/' + id + "/foods", 
                        { 
                            params:{
                                token:store.state.APIToken,
                                byDay:'true'     
                            }
                        })
                    .then(response => {
                        store.commit('updateDiningCenterMenu', {name:name, data:response.data})
                        console.log(response.data)
                    })
        }
    },
    getters:{
        selectDate: state => {
            return state.selectedDate;
          }
    }
})