<template>
    <div>
       <h4> {{diningCenterName}} </h4>
      
       <app-add-food></app-add-food>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                diningCenterName: ''
            }
        },

        computed: {
           
        },

        watch: {
         '$route' (to, from) {
                this.diningCenterName = this.$route.params.location
                this.$store.dispatch('getDiningCenterMenu', this.diningCenterName)
            }
        },

        mounted() { 
            this.diningCenterName = this.$route.params.location
            this.$store.dispatch('getDiningCenterMenu', this.diningCenterName)
        }
    }
</script>
