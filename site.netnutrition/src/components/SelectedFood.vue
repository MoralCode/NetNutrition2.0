<template>
    <div class="selected-food-container container">

         <div class="pull-right">
            <button type="button" class="btn btn-info">View</button>
            <button type="button" class="btn btn-success" @click="submitFood()">Submit</button>
       </div>
        <b>{{numSelectedFood}}</b> Foods Selected <br>
        {{selectedFoodMacros.calories}} Calories | 
       
      <div>
            
      </div>

    </div>
</template>

<script>
    export default {
       data(){
            return{
              showSelectedList:false
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
             submitFood: function(){
                this.$store.commit('submitFood')
             }
          
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
       
       
        background-color:rgb(250,250,250);
        padding:5px;
        box-shadow: 0px -3px 10px rgba(0,0,0,.2);

    }
</style>