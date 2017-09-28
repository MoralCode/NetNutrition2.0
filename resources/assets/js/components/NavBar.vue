<template>
    <div class='nav-bar'>
        <ul class="nav nav-pills">
            <li role="presentation">  <a href="#">Home</a> </li>
            <li role="presentation">
                <router-link to="/food-log">Food Log</router-link>
            </li>
            <li role="presentation">  
                 <router-link to="/dining-centers"> + Add Food </router-link>
            </li>
           
        </ul>
        
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
    }
</style>
