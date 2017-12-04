<template>
   
    <div class="container foodLogContainer">
        <div v-if="downloading" v-show="false">
            <iframe :src="this.$store.state.downloadLink" />
        </div>
       
        <h4> Food Log</h4>
         <label> Date </label>
         <datepicker input-class="datepickerInput" v-model="date" v-on:selected ="changeDate"></datepicker>
        <h5> {{totalMacros.calories}} Calories </h5>
        <h6>
        {{totalMacros.fat}} Fat |
        {{totalMacros.carbs}} Carbs |
        {{totalMacros.protein}} Protein 
        </h6>
                 
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Food</th>
                                    <th>Serving</th>
                                    <th>Calories</th>
                                     <th>Fat/Carb/Prot.</th>
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
                                        {{formatMacros(item.food['Total Fat']) * item.servings}} /
                                        {{formatMacros(item.food['Total Carbohydrate']) * item.servings}} /
                                        {{formatMacros(item.food['Protein']) * item.servings}} 
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                           
                        </div>
                        <button class="btn btn-default" @click="downloadData">Download History</button>
    
                    </div>
        

        </div>
        
</template>

<script>
    export default {
        name:'FoodLogView',
        data(){
            return{
               date:new Date(),
               downloading: false
            }
        },
      
        mounted() {
             if (this.$route.params.date != undefined){
                    this.date = new Date(this.$route.params.date)

            }
            else {
                this.date = new Date()
                this.$store.dispatch('fetchFoodLog', this.date)
            }
        },
        methods:{
            changeDate: function(event){
                this.$store.dispatch('fetchFoodLog', event)
            },
            formatMacros:function(str){
                return isNaN(parseInt(str)) ? 0:parseInt(str);
            },
            downloadData(){
                this.downloading = true;
                this.$store.dispatch('exportData', {});
                //give the iFrame 5 seconds to download the file
                setTimeout(()=>{this.downloading = false;}, 3000);

            },
            printDownloading(){
                console.log(this.downloading);
            }
        },
        computed:{
           foodLog: function(){
               return this.$store.state.foodLog
           },
           
            totalMacros: function() {
                let macros = {
                    calories:0,
                    fat:0,
                    carbs: 0,
                    protein: 0
                }

                for (let id in this.foodLog){
                    let item = this.foodLog[id]
                    macros.calories +=  (this.formatMacros(item.food['Calories']) * item.servings)
                    macros.fat += (this.formatMacros(item.food['Total Fat']) * item.servings)
                    macros.carbs += (this.formatMacros(item.food['Total Carbohydrate']) * item.servings)
                    macros.protein += (this.formatMacros(item.food['Protein']) * item.servings)
                }
                return macros
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

<style>
    .foodLogContainer{
        padding-bottom: 90px;
    }
</style>
