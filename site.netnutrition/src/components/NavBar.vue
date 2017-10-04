<template>
    <div class="nav-container">
        <div class="container">
            <h4> NetNutrition 2.0 </h4>
        </div>
        <div class='nav-bar'>
            <ul class="nav nav-tabs">
                <li role="presentation">  <a href="#">Home</a> </li>
                <li role="presentation">
                    <router-link to="/food-log">Food Log</router-link>
                </li>
                <li role="presentation">  
                    <router-link to="/dining-centers"> + Add Food </router-link>
                </li>
            
            </ul>
            
        </div>
    </div>
</template>

<script>
    export default {
        name:'dining-centers-page',
        mounted() {
            console.log('Dining centers')
        }
    }
</script>

<style>
    .nav-bar {
       border-bottom: 1px solid rgb(200,200,200);
       padding-top: 0px;
    }
    .nav-container {
        background-color: #ecf0f1;
    }
</style>
