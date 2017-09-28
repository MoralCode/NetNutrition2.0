<template>
    <div>
       
        <div class="container">
            <router-view></router-view>
        </div>  
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>