<template>
    <div class="nav-container">
        
        <div class='nav-bar'>
            <ul class="nav nav-tabs">
                <li role="presentation">  
                    <router-link to="/home">Home</router-link>
                </li>
                <li role="presentation">
                    <router-link to="/food-log">Log</router-link>
                </li>
                <li role="presentation">  
                    <router-link to="/dining-center"> + Food </router-link>
                </li>
                <li role="presentation">  
                    <router-link to="/stats"> Stats </router-link>
                </li>
                <li role="presentation">  
                    <a @click="logout"> Logout </a>
                </li>
            
            </ul>
            
        </div>
    </div>
</template>

<script>
    export default {
        name:'dining-centers-page',
        methods:{
            logout() {
                this.$store.dispatch('logout')
            }
        },
        mounted() {
            
        }
    }
</script>

<style>
    .nav-bar {
       border-bottom: 1px solid rgb(220,220,220);
       
    }
    .nav-container {
       
    }
</style>
