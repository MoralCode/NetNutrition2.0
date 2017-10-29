<template>
    <div class="selected-food-container container">
        <b>{{numSelectedFood}}</b> Foods Selected <br>
        {{selectedFoodMacros.calories}} Calories | 
       

    </div>
</template>

<script>
    export default {
       data(){
            return{
              
            }
        },
        computed:{
          numSelectedFood: function(){
            let selectedFoods = this.$store.state.selectedFoods
            return Object.keys(selectedFoods).length
          },
          selectedFoodMacros: function(){
              let selectedFoods = this.$store.state.selectedFoods
              let macros = {
                  calories:0,
                  fat:0,
                  carbs:0,
                  protein:0
              }
              for (let id in selectedFoods){
                  macros.calories += selectedFoods[id]['food']['Calories'] * selectedFoods[id]['servings'] 
               
              }
              return macros
          }
           
        },
        methods:{
             
          
        },
        mounted(){
            
          
        }
    }
</script>
<style>
    .selected-food-container {
        position:fixed;
        bottom:0;
        width:100%;
        height:5em;
       
        background-color:rgb(250,250,250);
        padding:5px;
        box-shadow: 0px -3px 10px rgba(0,0,0,.2);

    }
</style>