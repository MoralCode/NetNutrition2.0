<template>
    <div>
        <div v-for="(value,key) in diningCenterMenu">
            <h6><b>{{key}}</b></h6>
            <ul class="list-group">
                <li class="list-group-item" v-for="(food,key) in value"  v-on:click="increment(food)" v-bind:class="{'list-group-item-success':isSelected(food)}" >

                   <div class="pull-right">
                      
                      <button type="button" class="btn btn-default btn-sm" @click="$event.stopPropagation(); decrement(food)">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                         <button class="btn btn-default btn-sm" id="show-modal" @click="$event.stopPropagation(); food.modal = true">
                                <span class="glyphicon glyphicon-info-sign"></span>
                        </button>
                        <br><br>
                        <span class="badge">{{numServings(food)}}</span>
                    </div>
                  
                    <b>{{food['name']}}</b> <br>
                    {{food['servingSize']}} <br>
                    {{food['Calories']}} Calories <br>
                    {{formatMacros(food['Total Fat'])}} Fat |
                    {{formatMacros(food['Total Carbohydrate'])}} Carbs |
                    {{formatMacros(food['Protein'])}} Prot. 
                    {{food.modal}}
                    <app-nutrition-label v-if="food.modal" @close="food.modal = false" :foodItem = "food" ></app-nutrition-label>
                </li>
            </ul>   
                        
        </div>
    </div>
</template>

<script>
    export default {
        food(){
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
            }
          
        },
        mounted(){
           console.log(this.diningCenterMenu);
          
        }
    }
</script>
<style>

</style>