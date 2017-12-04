<template>
    <div>
        <div v-for="(value,key) in diningCenterMenu.stations">
            <h6><b>{{key}}</b></h6>
            <ul class="list-group">
                <li class="list-group-item" v-for="(food,key) in value"  v-on:click="increment(food)" v-bind:class="{'selected':isSelected(food)}" >

                   <div class="pull-right">
                      
                        <button type="button" class="btn btn-default btn-sm" @click="$event.stopPropagation(); decrement(food)">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                        <button class="btn btn-default btn-sm" id="show-modal" @click="$event.stopPropagation(); food.modal = true">
                                <span class="glyphicon glyphicon-info-sign"></span>
                        </button>
                       
                        <span class="badge">{{numServings(food)}}</span>
                    </div>
                  
                   
                    <b v-bind:class="{'allergy-text':isAllergic(food)}" >
                        {{food['name']}} <span v-if="isAllergic(food)">(Allergy Warning!)</span>  
                    </b><br>
                    {{food['servingSize']}} |
                    {{food['Calories']}} Calories <br>
                    {{formatMacros(food['Total Fat'])}} Fat |
                    {{formatMacros(food['Total Carbohydrate'])}} Carbs |
                    {{formatMacros(food['Protein'])}} Prot. 
                    <br>
                    <span v-bind:class="{'allergy-text':isAllergic(food)}"><b>Contains:</b></span>
                    <span v-for="allergen in food['allergens']">{{allergen}}, </span>
                    
                    <app-nutrition-label v-if="food.modal" @close="food.modal = false" :foodItem = "food" ></app-nutrition-label>
                </li>
            </ul>   
                        
        </div>
        <br><br><br><br><br>
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
    
            },
            userAllergens:function(){
                return this.$store.state.userSettings.allergens
            }

           
           
        },
        methods:{
             formatMacros:function(str){
                return isNaN(parseInt(str)) ? "< 1":parseInt(str);
            },
            increment:function(food){
              this.$store.commit('incrementSelectedFood', food) 
            },
            decrement:function(food){
                this.$store.commit('decrementSelectedFood', food)
            },
            isSelected: function(food){
                let selectedFoods = this.$store.state.selectedFoods
                if (food.id in selectedFoods){
                    return true
                }
                return false
            },
             numServings: function(food){
                let selectedFoods = this.$store.state.selectedFoods
                if (food.id in selectedFoods){
                    return selectedFoods[food.id].servings
                }
                return 0
            },
            isAllergic: function(food){
                for(let foodAllergen of food['allergens']){
                    for (let userAllergen of this.userAllergens){
                        if (userAllergen.name == foodAllergen && userAllergen.allergic){
                            return true
                        }
                    }
                }
                return false
            }
          
        },
        mounted(){
           
        }
    }
</script>
<style>
    .allergy-text {
        color:#e74c3c;
    }
    .selected {
        background-color:rgba(46, 204, 113,.3)
    }

</style>