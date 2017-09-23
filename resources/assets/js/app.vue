<template>
    <div class="container">
         <router-link to="/dining-centers">Dining Centers</router-link><br>
         <router-link to="/food-log">Food Log</router-link>
         <router-view></router-view>
    </div>  
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>