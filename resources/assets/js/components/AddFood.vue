<template>
    <div class="container">
        <div class="row">

            <section class="content">
                <div class = "row">
                    <h1>Select Food Options</h1>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-container">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Food</th>
                                            <th>Serving</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="item in pageList" v-bind:id="item.id"  v-on:click="select(item)"  v-bind:class="{'alert-success':item.selected}">
                                                <td>
                                                    {{ item.name }}
                                                </td>
                                                <td>
                                                    {{item.serving}}
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
                                        <li><a href="#" v-on:click="decPage">Previous</a></li>
                                        <li><a href="#" v-on:click="incPage">Next</a></li>
                                        <li><a href="#">{{page}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <h1>Selected Food</h1>
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-container">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Food</th>
                                            <th>Serving</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tr v-for="(item, index) in selected" :key="item.id" >
                                            <td>
                                                {{ item.name }}
                                            </td>
                                            <td>
                                                {{item.serving}}
                                            </td>
                                            <td v-on:click="$event.stopPropagation(); deSelect(item)">
                                                <button type="button" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-default btn-sm alert alert-success" id="submitButton">
                        Submit
                    </button>
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
                item.serving += 1;
                $("#" + item.id).attr('class', 'alert alert success');
            },
            decServing:function(item){
                if(item.serving > 1){
                    item.serving -= 1;
                }
                else if(item.serving == 1){
                    this.deSelect(item);
                }

            },
            deSelect: function(item){
                item.selected = false;
                item.serving = 0;
                $("#" + item.id).attr('class', '');
            }




        },
        mounted(){
            var item = function (selected, food, serving, id){
                return {
                    id:id,
                    selected: selected,
                    name: food,
                    serving: serving
                }
            }

            //Added function to create more complex object in future
            var diningCenter = function(name){
                return {
                    name:name
                }
            }

            //Push fake data to food items array
            this.items.push(item(true, "spaghetti",0, 0));
            this.items.push(item(false, "Lasagna bread", 0, 1));
            this.items.push(item(false, "PIZZA dude", 0, 2));
            this.items.push(item(false, "Burger", 0, 3));
            this.items.push(item(false, "Burger1", 0, 4));
            this.items.push(item(false, "Burger2", 0, 5));
            this.items.push(item(false, "Burger3", 0, 6));
            this.items.push(item(false, "Burger4", 0, 7));
            this.items.push(item(false, "Burger5", 0, 8));
            this.items.push(item(false, "Burger6", 0, 9));
            this.items.push(item(false, "Burger8", 0, 10));
            this.items.push(item(false, "Burger97", 0, 11));
            this.items.push(item(false, "Burger10", 0, 12));
            this.items.push(item(false, "Burger11", 0, 13));
            this.items.push(item(false, "Burger12", 0, 14));
            this.items.push(item(false, "Burger13", 0, 15));
            this.items.push(item(false, "Burger14", 0, 16));
            this.items.push(item(false, "Burger715",0, 17));
            this.items.push(item(false, "Burger134", 0, 18));
            this.items.push(item(false, "Burger8", 0, 19));
            this.items.push(item(false, "Burger97", 0, 20));
            this.items.push(item(false, "Burger10", 0, 21));
            this.items.push(item(false, "Burger11", 0, 22));
            this.items.push(item(false, "Burger12", 0, 23));
            this.items.push(item(false, "Burger13", 0, 24));
            this.items.push(item(false, "Burger14", 0, 25));
            this.items.push(item(false, "Burger715", 0, 26));
            this.items.push(item(false, "Burger134", 0, 27));

        },


    }
</script>
