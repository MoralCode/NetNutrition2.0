<template>
   
    <div>
        <label> Date </label>
         <datepicker input-class="datepickerInput" v-model="date" v-on:selected ="changeDate"></datepicker>
        <h4> Food Log</h4>
       
                 
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Serving</th>
                                    <th>Calories</th>
                                     <th>F/C/P</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(item,id) in foodLog" >
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
                                       
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                           
                        </div>
                    </div>
                </div>
        
</template>

<script>
    export default {
        name:'FoodLogView',
        data(){
            return{
               date:new Date()
            }
        },
      
        mounted() {
             if (this.$route.params.date != undefined){
                    this.date = new Date(this.$route.params.date)
            }
            else {
                this.date = new Date()
            }
        },
        methods:{
          changeDate: function(event){
             this.$store.dispatch('fetchFoodLog', event)
          }
        },
        computed:{
           foodLog: function(){
               return this.$store.state.foodLog
           }
        
        },
        watch: {
         '$route' (to, from) {
                if (this.$route.params.date != undefined){
                    
                }
                else {
                    this.date = new Date()
                }

                
            }
        },

        
    }

</script>
