<template>
<div>
    <app-nav-bar v-if="loggedIn"></app-nav-bar>
    <div class="container appContainer">
      <router-view></router-view>
      
    </div>
    <app-selected-food  v-if="loggedIn"></app-selected-food>
  </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'app',
    mounted() {

          

          let token = localStorage.getItem('api-token')
          //if token not in localstorage, redirect to login page
          if (!token){
              this.$router.replace('/login')
          }
          //check is token is valid by calling logged-in endpoint
          else {
              axios.get(process.env.API_DOMAIN + '/food-log', {params:{token: token}})
                    .then(response => {
                        if ('authorized' in response.data){
                            console.log("token is not valid")
                            this.$router.replace('/login')
                        }
                        else {
                            console.log(token, "is valid")
                            this.$store.commit('updateAPIToken',token)
                            this.$store.dispatch('loginSuccess')
                            this.$store.state.userSettings.netId = response.data[0].net_id
                        }
                    })
          }

          
          
     
         
      },
    computed: {
        loggedIn: function(){
            return this.$store.state.loggedIn
        }
    }

}
</script>

<style>
@import './assets/style/bootstrap-3.3.7-paper/dist/css/bootstrap.min.css';

.appContainer{
    padding-top:1em;
}
</style>
