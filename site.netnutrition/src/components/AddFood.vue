<template>
    <div class="container">
        <div class="row">
            
            <section class="content">
               
                <h4>Select Food Options</h4>
                Tap item once for each serving
                <app-date-picker></app-date-picker>
                <app-dining-center-select></app-dining-center-select>
                    <div id="foodTables" v-show="diningCenter()">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Servings</th>
                                    <th>Calories</th>
                                    <th>F/C/P</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in pageList" v-bind:id="item.id"  v-on:click="select(item)"  v-bind:class="{'success':item.selected}">
                                        <td>
                                            {{ item.name }}
                                        </td>
                                        <td>
                                            {{item.servings}}
                                        </td>
                                        <td>
                                            {{item.calories}}
                                        </td>
                                            <td>
                                            {{item.fat}}/{{item.carbs}}/{{item.protein}}
                                        </td>
                                        <td v-on:click="$event.stopPropagation(); decServing(item)">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <ul class="pager">
                                <li><a  v-on:click="decPage">Previous</a></li>
                                <li><a v-on:click="incPage">Next</a></li>
                                <li><a>{{page}}</a></li>
                            </ul>
                        </div>
                           
                  
                
              
                        <h4>Selected Food</h4>
                                
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Servings</th>
                                    <th>Calories</th>
                                        <th>F/C/P</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tr v-for="(item, index) in selected" :key="item.id" >
                                    <td>
                                        {{ item.name }}
                                
                                    </td>
                                    <td>
                                        {{item.servings}}
                                    </td>
                                    <td>
                                        {{item.calories * item.servings}}
                                    </td>
                                        <td>
                                            {{item.fat * item.servings}}/{{item.carbs * item.servings}}/{{item.protein * item.servings}}
                                        </td>

                                    <td v-on:click="$event.stopPropagation(); deSelect(item)">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <button v-on:click="submitFood()" type="button" class="btn btn-default btn-sm alert alert-success" id="submitButton">
                                Submit
                            </button>
                        </div>
                    </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                items:[],
                itemsPerPage:8,
                page:0
            }
        },
        props:{
            foodData:{
                default:()=>[]
            }
        },
        watch:{
            foodData () {
                this.items =  this.foodData.map(elem => Object.assign({}, elem))
            }
        },
       
        computed:{

            pageList:function() {    //referenced in your template just as booksList
                return this.items.slice(this.page * this.itemsPerPage, (this.page + 1)* this.itemsPerPage);
            },
            selected:function(){
                return this.items.filter(function(item){
                    return item.selected;
                })
            }
        },
        methods:{
            decPage: function (event) {
                if(this.page != 0){this.page--;}

            },
            incPage: function(event){
                if(((this.page + 1)* this.itemsPerPage) < (this.items.length)){this.page++}
            },
            select: function(item){
                item.selected = true;
                item.servings += 1;
               
            },
            decServing:function(item){
                if(item.servings > 1){
                    item.servings -= 1;
                }
                else if(item.servings == 1){
                    this.deSelect(item);
                }

            },
            deSelect: function(item){
                item.selected = false;
                item.servings = 0;
               
            },
            clearSelected: function(){
                this.items.forEach(item => {
                    item.selected = false,
                    item.servings = 0
                })
            },
            submitFood: function(){
                //deep copy the array
                this.$store.commit('addToFoodLog', this.selected.map(elem => Object.assign({}, elem)))
                this.clearSelected()
              
            },
            diningCenter:function(){
               
                return this.$store.state.selectedDiningCenter !== undefined;
                
            }
        },
        mounted(){
          
            
        }
    }
</script>
