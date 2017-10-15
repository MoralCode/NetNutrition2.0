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
            axios.get('http://api.netnutrition.dev/dining-center', {params:{token:store.state.APIToken}})
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
            axios.get("http://api.netnutrition.dev/dining-center/" + 11 + "/viewFoodOptions", {params:{token:store.state.APIToken}})
                    .then(response => {
                        //transform data into nested key-value dictionary
                        console.log(response.data)
                    })


        }
    },
    getters:{}
})