<template>
    <div>
    <br>
        <h4> Hello, Kyle! </h4>
        <h5>{{currentDate}} </h5>
        <hr>
        
        <h5> {{totalCalories}} / 2700 Calories </h5>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" 
            v-bind:style="{width:totalCalories/2700 * 100 + 5 + '%'}"></div>
        </div>

        <div class="row">
            <div class="col-xs-2">Fat:</div>
            <div class="col-xs-7">  
                 <div class="progress" style="margin-top:.5em">
                     <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                      v-bind:style="{width:totalFat/60 * 100 + 5 + '%'}"></div>
                </div>
            </div>
            <div class="col-xs-3">{{totalFat}}/60</div>
        </div>

        <div class="row">
            <div class="col-xs-2">Carbs</div>
            <div class="col-xs-7">  
                 <div class="progress" style="margin-top:.5em">
                     <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                      v-bind:style="{width:totalCarbs/300 * 100 + 5 + '%'}"></div>
                </div>
            </div>
             <div class="col-xs-3">{{totalCarbs}}/300 </div>
        </div>

        <div class="row">
            <div class="col-xs-2" >Protien</div>
            <div class="col-xs-7">  
                 <div class="progress" style=" margin-top:.5em;">
                     <div class="progress-bar progress-bar-infor" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" 
                      v-bind:style="{width:totalProtein/150 * 10 + 5 + '%'}"></div>
                </div>
            </div>
              <div class="col-xs-3">{{totalProtein}}/150 </div>
        </div>
     

           
                  
                  
               
           
       
           
    </div>
</template>

<script>
    export default {

        computed: {
            totalCalories() {
               // return this.$store.state.foodLog.reduce((total,item) =>{return total + item.calories * item.servings}, 0)
               return 0
            },
            totalFat() {
                //return this.$store.state.foodLog.reduce((total,item) =>{return total + item.fat * item.servings}, 0)
                return 0
            },
            totalCarbs() {
                //return this.$store.state.foodLog.reduce((total,item) =>{return total + item.carbs * item.servings}, 0)
                return 0
            },
            totalProtein() {
                //return this.$store.state.foodLog.reduce((total,item) =>{return total + item.protein * item.servings}, 0)
                return 0
            },

            currentDate() {
                return new Date().toDateString()
            }

           
        },
      
        mounted() {
            console.log('Dining centers')
        }
    }
</script>

<style>
      button a {
        color:white;
    }
</style>
