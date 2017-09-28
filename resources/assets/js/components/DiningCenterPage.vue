<template>
    <div>
       <h3> {{diningCenterName}} </h3>

       <app-add-food></app-add-food>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                diningCenterName: this.$route.params.location
            }
        },

        mounted() {}
    }
</script>
