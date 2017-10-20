<template>
    <div>
       
       <app-add-food v-bind:food-data="diningCenterMenu"></app-add-food>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                diningCenterName: ''
            }
        },

        computed: {
           diningCenterMenu(){ 
                    let data = this.$store.state.diningCenterData.diningCenterMenus[this.diningCenterName] 
                    //generate some fake calorie and macro data and attach servings and selected properties
                    let items = []
                    for (let key in data){
                        for (let item in data[key]['foods']){

                            let newItem = Object.assign({},data[key]['foods'][item])
                            newItem.calories = 100
                            newItem.fat = 10
                            newItem.carbs = 25
                            newItem.protein = 20
                            newItem.servings = 0
                            newItem.selected = false
                            newItem.id = 1
                           

                            items.push(newItem)
                        }
                    }
                    return items
               }
        },

        watch: {
         '$route' (to, from) {
                this.diningCenterName = this.$route.params.location
                this.$store.dispatch('getDiningCenterMenu', this.diningCenterName)
            }
        },

        mounted() { 
            this.diningCenterName = this.$route.params.location
            this.$store.dispatch('getDiningCenterMenu', this.diningCenterName)
        }
    }
</script>
