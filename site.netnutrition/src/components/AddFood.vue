<template>
    <div>
        <div v-for="(value,key) in diningCenterMenu">
            <b>{{key}}</b>
            <ul class="list-group">
                <li class="list-group-item" v-for="(data,food) in value">
                    <span class="badge">14</span>
                    <b>{{food}}</b> <br>
                    {{data['servingSize']}} <br>
                    {{data['Calories']}} Calories <br>
                    {{data['Total Fat']}} Fat |
                    {{data['Total Carbohydrate']}} Carbs |
                    {{data['Protein']}} Prot. 
                    

                </li>
            </ul>               
        </div>
    </div>
</template>

<script>
    export default {
        data(){
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
               
            }
           
        },
        methods:{
          
        },
        mounted(){
            
          
        }
    }
</script>
<style>

</style>