<template>
    <div>
       <h4> {{diningCenterName}} </h4>
      
    
       <app-add-food v-bind:food-data="diningCenterMenu"></app-add-food>
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
           diningCenterMenu(){ 
                   return this.$store.state.diningCenterData;
               }
        },

        watch: {
         '$route' (to, from) {
                this.diningCenterName = this.$route.params.location
                this.$store.dispatch('fetchDiningCenterMenu', this.diningCenterName)
            }
        },

        mounted() { 
            this.diningCenterName = this.$route.params.location
            this.$store.dispatch('fetchDiningCenterMenu', this.diningCenterName)
            console.log(this.$store.state.diningCenterMenu);
        }
    }
</script>
