<template>
    <div class="container">
        <h3>Total Calories: {{totalCalories}}</h3>
        <h4>Total Protein: {{totalProtein}}</h4>
        <h4>Total Carbs: {{totalCarbs}}</h4>
        <h4>Total Fat: {{totalFat}}</h4>
        
        
    </div>
</template>

<script>
    export default {
        data(){
            return{
                totalCalories:0,
                totalProtein:0,
                totalCarbs:0,
                totalFat: 0
            }
        },
        mounted() {
            console.log(this.foodData);
        },
        props:{
             foodData:{
                default:()=>{}
            }
        },
        watch:{
            foodData(){
                var foodIds = Object.keys(this.foodData);

                this.totalCalories = this.totalCarbs = this.totalProtein = this.totalFat = 0;
                
                foodIds.forEach(elem =>{
                    
                    this.totalCalories += parseInt(this.foodData[elem].food.Calories) || 0;
                    this.totalCarbs += parseInt(this.foodData[elem].food["Total Carbohydrate"]) || 0;
                    this.totalProtein += parseInt(this.foodData[elem].food.Protein) || 0;
                    this.totalFat += parseInt(this.foodData[elem].food["Total Fat"]) || 0;
                });
            }
        }
    }
</script>