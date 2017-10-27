<template>
    <div>
        {{diningCenterMenu}}
    </div>
</template>

<script>
    export default {
        data(){
            return{
              
            }
        },
        computed:{
            diningCenterMenu: function(){
                let selectedDiningCenter = this.$store.state.selectedDiningCenter
                let selectedMeal = this.$store.state.selectedMeal
                if (selectedDiningCenter != undefined && selectedMeal != undefined){
                     return this.$store.state.diningCenterData.diningCenterMenus[selectedDiningCenter][selectedMeal]
                }
                return {}
               
            }
           
        },
        methods:{
          
        },
        mounted(){
            
          
        }
    }
</script>
<style>

</style>