<template>
<div>
    <app-nav-bar></app-nav-bar>
      <div class="container">
      <router-view></router-view>
      
    </div>
    <app-selected-food></app-selected-food>
  </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'app',
    mounted() {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", process.env.API_DOMAIN + '/login' , true);

          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = () => {//Call a function when the state changes.
              if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                  let data = JSON.parse(xhr.response)
                  this.$store.commit('updateAPIToken', data.token)
                  this.$store.dispatch('getDiningCenterData')
              }
          }
          xhr.send('net_id=sjpipho&password=sethpw');
      }
}
</script>

<style>
@import './assets/style/bootstrap-3.3.7-paper/dist/css/bootstrap.min.css'

</style>
