<template>
<div>
    <app-nav-bar></app-nav-bar>
      <div class="container">
    <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: 'app',
    mounted() {
            console.log(this.$store)
            this.$store.dispatch('getDiningCenterData')
        }
}
</script>

<style>
@import './assets/style/bootstrap-3.3.7-paper/dist/css/bootstrap.min.css'

</style>
