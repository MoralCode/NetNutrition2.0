<template>
    <div>
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
               
            }
        },
      
        mounted() {
        
        },
        methods:{
          
        },
        computed:{
           foodLog: function(){
               return this.$store.state.foodLog
           }
        
        }
    }

</script>
