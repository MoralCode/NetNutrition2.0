<template>
    <div>
       <h5> Profile </h5>
       {{userSettings}}
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
              userSettings:{},
              settingsChanged:false
            }
        },

        computed:{
             
        },
     
        methods:{
            updateUserSettings: function(){
                this.$store.commit('updateUserSettings',this.userSettings)
                this.settingsChanged = false
            }
          
        },
        mounted(){
           this.userSettings = Object.assign({},this.$store.state.userSettings)
        }
    }
</script>
<style>

</style>