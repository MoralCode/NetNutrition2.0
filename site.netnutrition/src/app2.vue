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
        mounted() {
            console.log(this.$store)
            this.$store.dispatch('getDiningCenterData')
        }
    }
</script>

<style>
  
</style>