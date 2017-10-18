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
        }
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
        }
    },
    actions:{
        getDiningCenterData({ commit }){
            console.log("loading dining centers")
            console.log(process.env.API_DOMAIN)
            axios.get(process.env.API_DOMAIN + '/dining-center', {params:{token:store.state.APIToken}})
                    .then(response => {
                        console.log(response)
                        store.commit('updateDiningCenterData', response.data)
                        console.log("dining center data loaded")
                    })
        },

       
        //fetches the foods currently being served at a dining center
        fetchDiningCenterMenu({ commit }, name){
            //find the repesctive id of the dining center, needed for api call
            //let id = store.state.diningCenterData.diningCenters.find((elem) => {return elem.name == name} ).id
            let id = 11
            console.log('Name:', name, ",id:", id)

            //api call
            axios.get(process.env.API_DOMAIN + '/dining-center/' + 11 + "/view-food-options", {params:{token:store.state.APIToken}})
                    .then(response => {
                        console.log(response.data)      
                    })
        }
    },
    getters:{}
})