import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router'
Vue.use(Vuex)

export const store = new Vuex.Store({
    state:{
        APIToken:'',
        loggedIn:false,
        registerFail:false,
        foodLog:{},
        diningCenterData:{
            loading:true,
            diningCenters:[],
            diningCenterMenus:{},
        },
        selectedDate:new Date(),
        selectedDiningCenter:undefined,
        selectedMeal:undefined,
        selectedFoods:{},
        role:'',
        users:{},
        downloadLink: '',
        userSettings:{
            netId:'',
            goals:{
                calories:2500,
                fat:94,
                carbs:286,
                protein:156
            },
            allergens:[
                {name:"Wheat/Gluten",allergic:false},
                {name:"Soy",allergic:false},
                {name:"Fish",allergic:false},
                {name:"Dairy",allergic:false},
                {name:"Eggs",allergic:false},
                {name:"Shellfish",allergic:false},
                {name:"Dairy",allergic:false},
                {name:"Treenuts",allergic:false},
                {name:"Peanuts",allergic:false},
            ] 
        }
    },
    mutations: {

        submitFood(state){
            store.dispatch('postFoodLog')
            store.commit('updateFoodLog', state.selectedFoods)
            state.selectedFoods = {}      
        },

        updateFoodLog(state, foodData){
             
             for (let id in  foodData){
                if (!(id in state.foodLog)){
                    Vue.set(state.foodLog, id, foodData[id])
                }
                else {
                    state.foodLog[id].servings += foodData[id].servings
                }
            }
        },
        updateUserSettings(state,userSettings){
            state.userSettings = userSettings
        },
        replaceFoodLog(state, foodData){
            state.foodLog = {}
            store.commit('updateFoodLog', foodData)
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
        },
        deleteSelectedFood(state, id){
            if (!(id in state.selectedFoods)){
                return
            }
            else {
                 Vue.delete(state.selectedFoods, id)
            }
        }
    },
    actions:{
        loginSuccess( {commit}){
            store.dispatch('getDiningCenterData')
            store.dispatch('fetchFoodLog', new Date())
            store.dispatch('getRole');
            
            store.state.loggedIn = true

            router.replace('/home')
        },
        attemptLogin({commit}, payload)
        {
            console.log(payload)
            let xhr = new XMLHttpRequest();
            xhr.open("POST", process.env.API_DOMAIN + '/login' , true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {//Call a function when the state changes.
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    let data = JSON.parse(xhr.response)
                   
                    if (data.success){
                        store.commit('updateAPIToken', data.token)
                        localStorage.setItem('api-token', data.token)

                        store.state.userSettings.netId = payload.username
                        store.dispatch('loginSuccess')
                    }
                    else {
                        console.log('login failed')
                    }
                  
                   
                }
            }
            xhr.send('net_id=' + payload.username + '&password=' + payload.password);

        },
         attemptRegister({commit}, payload)
        {
            console.log(payload)
            let xhr = new XMLHttpRequest();
            xhr.open("POST", process.env.API_DOMAIN + '/signup' , true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {//Call a function when the state changes.
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    let data = JSON.parse(xhr.response)
                   console.log("register return", data)
                    if (data.success){
                        store.commit('updateAPIToken', data.token)
                        localStorage.setItem('api-token', data.token)

                        store.state.userSettings.netId = payload.username
                        store.state.registerFail = false
                        store.dispatch('loginSuccess')
                    }
                    else {
                        console.log('login failed')
                    }
                }
                 else if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 422) {
                     console.log("username not unique")
                     store.state.registerFail = true
                 }
            }
            xhr.send('net_id=' + payload.username + '&password=' + payload.password + '&password_confirmation=' + payload.confirmPassword);

        },
        logout({commit}){
            axios.get(process.env.API_DOMAIN + '/logout', {params:{token:store.state.APIToken}})
                    .then(response => {  
                        store.state.loggedIn = false
                        router.push('/login')
                    })
        },
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
            axios.get(process.env.API_DOMAIN + '/dining-center/' + id + "/view-food-options", {params:{token:store.state.APIToken,type:'today'}})
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
                                    
                                    //extract allergens
                                    foodDict[food.name]['allergens'] = food.allergens.reduce((allergens,allergen) => {
                                        allergens.push(allergen.name)
                                        return allergens
                                    },[])
                            
                                    //stuff for food display thing
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
                        let foodData = {}
                        let data = response.data[0]

                        if (data == undefined){
                            return
                        }

                        for (let i = 0; i < data.foods.length; i++){
                            let food = data.foods[i]
                       

                            if (food.id in foodData){
                                foodData[food.id].servings += parseInt(food.pivot.servings)
                            }
                            else {
                                //convert food nutrition to dictionary
                                let foodDict = {}
                                foodDict['id'] = food.id
                                foodDict['name'] = food.name

                                for (let item of food.nutritions){
                                    foodDict[item.name] = item.value
                                }

                                foodData[food.id] = {
                                    food: foodDict,
                                    servings: parseInt(food.pivot.servings),
                                    menu: data.menus[i]
                                }
                            }
                        }
                        store.commit('replaceFoodLog', foodData)
                    })
        },
        getRole({commit}){
            

            axios.get(process.env.API_DOMAIN + '/user/role', {params:{token: store.state.APIToken}})
                .then(response => {
                    console.log(response.data.name);
                    store.state.role = response.data.name;
                });
        },
        getUsers({commit}){
            axios.get(process.env.API_DOMAIN + '/user', {params:{token: store.state.APIToken}})
            .then(response => {
                store.state.users = response.data;

            });
        },
        editUser({commit}, payload){
            var callback = payload.callback;
            var id = payload.id;
            var role_id = payload.role_id;
            var net_id = payload.net_id;
            axios.get(process.env.API_DOMAIN + '/user/update/'+ id, {params:{token: store.state.APIToken, role_id: role_id, net_id: net_id}})
            .then(response => {
                
                callback();
            });
                
        },
        deleteUser({commit}, payload){
            var id = payload.id;
            var callback = payload.callback;
            axios.get(process.env.API_DOMAIN + '/user/destroy/'+ id, {params:{token: store.state.APIToken}})
            .then(response => {
                callback();
            });
        },
        exportData({commit}, payload){
            
            store.state.downloadLink = process.env.API_DOMAIN + '/analytics/food-log-to-csv?token=' + store.state.APIToken;
        },
        getMostEatenFoods({commit}, payload){
            var callback = payload.callback;

            axios.get(process.env.API_DOMAIN + '/analytics/most-eaten-food', {params:{token: store.state.APIToken}})
            .then(response => {
                callback(response);
            });
        }

    },
    getters:{
      
    }
})