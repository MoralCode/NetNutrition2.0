<template>
    <div class="selected-food-container container">

     <div class="selected-food-list" v-if="showSelectedList">
        <div class="table-container">
            <table class="table">
                <thead>
                <tr>
                    <th>Food</th>
                    <th>Serving</th>
                    <th>Calories</th>
                    <th>Fat/Carb/Prot.</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="(item,id) in selectedFoods" >
                    <td>
                       
                        {{item.food.name}} 
                    </td>
                    <td>
                        {{item.servings}}
                    </td>
                        <td>
                        {{item.servings * item.food['Calories']}}
                    </td>
                    <td>
                        {{formatMacros(item.food['Total Fat']) * item.servings}} /
                        {{formatMacros(item.food['Total Carbohydrate']) * item.servings}} /
                        {{formatMacros(item.food['Protein']) * item.servings}} 
                    </td>
                    <td>
                         <button @click="deleteFood(item.food.id)" type="button" class="btn btn-warning btn-xs">X</button>
                    </td>
                </tr>

                </tbody>
            </table>
            
        </div>
      </div>


         <div class="pull-right">
            <button type="button" class="btn btn-info" v-if="!showSelectedList" @click="showSelectedList = true">View</button>
            <button type="button" class="btn btn-info" v-if="showSelectedList" @click="showSelectedList = false">Hide</button>
            <button type="button" class="btn btn-success" @click="submitFood()">Submit</button>
       </div>
        <b>{{numSelectedFood}}</b> Foods Selected <br>
        {{totalMacros.calories}} Calories  <br>
        {{totalMacros.fat}} Fat |
        {{totalMacros.carbs}} Carbs |
        {{totalMacros.protein}} Prot. 
       
     
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
          totalMacros: function() {
                let macros = {
                    calories:0,
                    fat:0,
                    carbs: 0,
                    protein: 0
                }

                for (let id in this.$store.state.selectedFoods){
                    let item = this.$store.state.selectedFoods[id]
                    macros.calories +=  (this.formatMacros(item.food['Calories']) * item.servings)
                    macros.fat += (this.formatMacros(item.food['Total Fat']) * item.servings)
                    macros.carbs += (this.formatMacros(item.food['Total Carbohydrate']) * item.servings)
                    macros.protein += (this.formatMacros(item.food['Protein']) * item.servings)
                }
                return macros
            },

          selectedFoods: function(){
               return this.$store.state.selectedFoods
           },
           
        },
        methods:{
             submitFood: function(){
                this.$store.commit('submitFood')
                this.showSelectedList = false
             },
              formatMacros:function(str){
                return isNaN(parseInt(str)) ? 0:parseInt(str);
            },
            deleteFood: function(id){
                this.$store.commit("deleteSelectedFood", id)
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
    .selected-food-list {
        height: 30em;
        overflow:auto;

        padding: 5px;
    }
</style>