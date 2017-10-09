<template>
    <div>
    <app-food-log-view></app-food-log-view>
        
    </div>
</template>

<script>
    export default {
       
        computed: {
            foodLog() {
                return this.$store.state.foodLog
            },
            
        },
        mounted() {}
    }
</script>
