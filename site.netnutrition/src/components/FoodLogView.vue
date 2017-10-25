<template>
    <div>
        <h3> Food Log</h3>
        <div class = "row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>{{currentDate}}</h4>
                        <h4> {{totalCalories}} Calories </h4>
                        <h5> {{totalFat}} Fat / {{totalCarbs}} Carbs / {{totalProtein}} Protein</h5>
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

                                <tr v-for="item in pageList" v-bind:id="item.id">
                                    <td>
                                        {{ item.name }} 
                                    </td>
                                    <td>
                                        {{item.servings}}
                                    </td>
                                     <td>
                                        {{item.servings * item.calories}}
                                    </td>
                                    <td>
                                       {{item.fat * item.servings}}/{{item.carbs * item.servings}}/{{item.protein * item.servings}}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <ul class="pager">
                                <li><a v-on:click="decPage">Previous</a></li>
                                <li><a v-on:click="incPage">Next</a></li>
                                <li><a>{{page}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:'FoodLogView',
        data(){
            return{
                items:[],
                itemsPerPage:8,
                page:0
            }
        },
      
        mounted() {
        
        },
        methods:{
            decPage: function (event) {
                if(this.page != 0){this.page--;}

            },
            incPage: function(event){
                if(((this.page + 1)* this.itemsPerPage) < (this.items.length)){this.page++}
            },
            foodFormat: function(selected, food, serving, id){
                return {
                    id:id,
                    selected: selected,
                    name: food,
                    serving: serving
                }
            }
        },
        computed:{
            pageList:function() {
                return this.$store.state.foodLog.slice(this.page * this.itemsPerPage, (this.page + 1)* this.itemsPerPage);
            },
             totalCalories() {
                let foodLog = this.$store.state.foodLog
                return foodLog.reduce((total,item) =>{return total + item.calories}, 0)
            },
             totalFat() {
                return this.$store.state.foodLog.reduce((total,item) =>{return total + item.fat * item.servings}, 0)
            },
            totalCarbs() {
                return this.$store.state.foodLog.reduce((total,item) =>{return total + item.carbs * item.servings}, 0)
            },
            totalProtein() {
                return this.$store.state.foodLog.reduce((total,item) =>{return total + item.protein * item.servings}, 0)
            },
            currentDate() {
                return new Date().toDateString()
            }
        
        }
    }

</script>
