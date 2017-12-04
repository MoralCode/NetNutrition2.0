<template>
    <div>
       <h5> Profile </h5>
      
        <h6> Nutritional Goals </h6>
         <b>Calories:</b>  <input @change="macroChange()" type='number' v-model="userSettings.goals.calories"> <br>
         Fat: {{userSettings.goals.fat}} Grams <br>
         Carbs: {{userSettings.goals.carbs}} Grams <br>
         Protein: {{userSettings.goals.protein}} Grams <br>
         <hr>
        <h6> Allergens </h6>
        <div v-for="allergen in userSettings.allergens">
             <input @change="settingsChanged = true" type="checkbox" id="checkbox" v-model="allergen.allergic">
            <label for="checkbox">{{ allergen.name }}</label>
        </div>
        <hr>
        <button @click="updateUserSettings" :disabled="!settingsChanged"  class="btn btn-primary">Update Settings</button>
        
        <br><br><br><br><br><br>
    </div>
</template>

<script>
    export default {
        data(){
            return{
              userSettings:{goals:{calories:0}},
              settingsChanged:false
            }
        },

        computed:{
             
        },
     
        methods:{
            updateUserSettings: function(){
                this.$store.commit('updateUserSettings',this.userSettings)
                this.settingsChanged = false
            },
            macroChange(){
                this.userSettings.goals.fat = Math.round(this.userSettings.goals.calories * .3 / 8)
                this.userSettings.goals.carbs = Math.round(this.userSettings.goals.calories * .45 / 4)
                this.userSettings.goals.protein = Math.round(this.userSettings.goals.calories * .25 / 4)
                this.settingsChanged = true
            }
          
        },
        mounted(){
           this.userSettings = Object.assign({},this.$store.state.userSettings)
        }
    }
</script>
<style>

</style>