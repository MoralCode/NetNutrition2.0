<template>
    <div class="container" id="foodAdditionContainer">
        <div class="row">
            <section class="content addFoodTable">
                <h4>Select Food Options</h4>
                Tap item once for each serving
                    <div id="foodTables" v-show="diningCenter()">
                        <div class="table-container">
                            <table class="table" id="foodAdditionTable">
                                <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Servings</th>
                                    <th>Calories</th>
                                    <th class="col_1">Fat</th>
                                    <th class="col_2">Carbs</th>
                                    <th class="col_3">Protein</th>
                                    <th></th>
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
                                            {{item.Calories}}
                                        </td>
                                        <td class = "col_1">
                                            {{formatMacros(item["Total Fat"])}}g
                                        </td>
                                        <td class = "col_2"> 
                                            {{formatMacros(item["Total Carbohydrate"])}}g
                                        </td>
                                        <td class= "col_3">
                                            {{formatMacros(item.Protein)}}g
                                        </td>
                                        <td v-on:click="$event.stopPropagation(); decServing(item)">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-default btn-sm" id="show-modal" @click="$event.stopPropagation(); item.modal = true">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                            </button>
                                            <!-- use the nutrition-label component, pass in the prop -->
                                        </td>
                                        <app-nutrition-label :foodItem = "item" v-if="item.modal" @close="item.modal = false"/>
                                    </tr>
                                </tbody>
                            </table>
                            <ul class="pager">
                                <li><a  v-on:click="decPage">Previous</a></li>
                                <li><a v-on:click="incPage">Next</a></li>
                                <li><a>{{page}}</a></li>
                            </ul>
                        </div>
                        <div>
                            <button v-on:click="submitFood()" type="button" class="btn btn-default btn-sm alert alert-success" id="submitButton">
                                Submit
                            </button>
                        </div>
                    </div>
            </section>
        </div>{{diningCenterChange}}
    </div>
</template>

<script>
    export default {
        data(){
            return{
                items:[],
                itemsPerPage:8,
                page:0,
                prevDiningCenter:undefined,
                showModal:false
            }
        },
        computed:{

            pageList:function() {  
                return this.items.slice(this.page * this.itemsPerPage, (this.page + 1)* this.itemsPerPage);
            },
            selected:function(){
                return this.items.filter(function(item){
                    return item.selected;
                })
            },
            diningCenterChange: function(){
                var menu = this.$store.getters.selectFoods;
                this.items = menu;
               
                return this.$store.getters.selectFoods;
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
                //reset page to zero when selectedDining center changes
                if(this.$store.state.selectedDiningCenter !== this.prevDiningCenter){
                    this.page = 0;
                    this.prevDiningCenter = this.$store.state.selectedDiningCenter;
                }
                return this.$store.state.selectedDiningCenter !== undefined;
                
            },
            formatMacros:function(str){
                return isNaN(parseInt(str)) ? "< 1":parseInt(str);
            }
        },
        mounted(){
            
          
        }
    }
</script>
<style>
#foodAdditionTable{
    float:left;
    border-collapse:collapse;   
    width:100%;
    font-size:12px;
}
/* #Tablet (Portrait)
================================================== */
/* Note: Design for a width of 768px */
@media all and (min-width: 768px) and (max-width: 959px) {
    td.col_1, th.col_1{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;       
    } 
    

}
/* #Mobile (Landscape)
================================================== */
/* Note: Design for a width of 600px */
@media all and (min-width: 600px) and (max-width: 767px) {
    td.col_1, th.col_1{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;       
    } 
    td.col_2, th.col_2{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;
    } 
    #foodAdditionContainer{
        padding-left:5px;
        padding-right:5px;
    }
}
/* #Mobile (Landscape)
================================================== */
/* Note: Design for a width of 480px */
@media all and (min-width: 480px) and (max-width: 599px) {
    td.col_1, th.col_1{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;       
    } 
    td.col_2, th.col_2{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;
    } 
    td.col_3, th.col_3{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;
    } 
    #foodAdditionContainer{
        padding-left:5px;
        padding-right:5px;
    } 
}
/*  #Mobile (Portrait)
================================================== */
/* Note: Design for a width of 320px */
@media all and (max-width: 479px) {
    td.col_1, th.col_1{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;       
    } 
    td.col_2, th.col_2{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;
    } 
    td.col_3, th.col_3{
        display:none;
        width:0;
        height:0;
        opacity:0;
        visibility: collapse;
    } 
    #foodAdditionContainer{
        padding-left:5px;
        padding-right:5px;
    } 
}
</style>