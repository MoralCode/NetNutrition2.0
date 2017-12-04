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
                <li role="presentation" v-if="admin">
                    <router-link to="/admin"> Admin </router-link>
                </li>
                <li role="presentation" v-if="chef">
                    <router-link to="/chef"> Chef </router-link>
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

        name:'NavBar',
        name:'dining-centers-page',
        methods:{
            logout() {
                this.$store.dispatch('logout')
            }
        },
        mounted() {
            
        },
        computed:{
            role(){
                console.log(this.$store.state.role);
                return this.$store.state.role;
            },
            admin(){
                return this.role === 'Admin';
            },
            chef(){
                return this.role ==='Admin' || this.role === 'Chef';
            }
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
