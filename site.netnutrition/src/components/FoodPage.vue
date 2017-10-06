<template>
    <div>
       <h4> {{diningCenterName}} </h4>
      
      {{diningCenterName}}
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
           diningCenterMenu(){ return this.$store.state.getDiningCenterMenu(this.diningCenterName)}
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
