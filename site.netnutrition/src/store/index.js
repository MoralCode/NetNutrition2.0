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
            diningMenus:{},
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
        updateDiningCenterMenu(state, name, data){
            state.diningCenterData.diningMenus[name] = data
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
                    .then(reponse => {
                        console.log(reponse)
                        store.commit('updateDiningCenterData', reponse.data)
                        console.log("dining center data loaded")
                    })
        },

        getDiningCenterMenu({ commit }, name ){
            console.log(name)
            let id = store.state.diningCenterData.diningCenters.find((elem) => {return elem.name == name} ).id
            axios.get('http://netnutrition.dev/api/dining-center/' + id + "/menus")
                    .then(reponse => {
                        store.commit('updateDiningCenterMenu', name, reponse.data)
                        console.log(reponse.data)
                    })
        }
    },
    getters:{}
})