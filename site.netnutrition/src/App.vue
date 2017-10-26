<template>
<div>
    <app-nav-bar></app-nav-bar>
      <div class="container">
    <router-view></router-view>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'app',
    mounted() {
            
            axios.get(process.env.API_DOMAIN + '/login' ,{params:{net_id:'sjpipho',password:'sethpw'}})
                .then(response => {
                  console.log(response.data.token)
                  this.$store.commit('updateAPIToken', response.data.token)
                  this.$store.dispatch('getDiningCenterData')
                })
        }
}
</script>

<style>
@import './assets/style/bootstrap-3.3.7-paper/dist/css/bootstrap.min.css'

</style>
