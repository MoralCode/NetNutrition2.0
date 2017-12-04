<template>
    <div class="container chefContainer">
        <h4>MOST EATEN FOODS</h4>
        <ul class="list-group">
            <li class="list-group-item" v-for="food in mostEatenFoods">

                
                <b>{{food.name}}</b><br>
                Servings: <b>{{food.totalServings}}</b><br>
                
            </li>
        </ul>   
    </div>
</template>

<script>
    export default {
        name:'Chef',
        data(){
            return{
                mostEatenFoods: {}
            }
        },
        mounted() {
            var callback = (response) => {this.mostEatenFoods = response.data;}
            this.$store.dispatch('getMostEatenFoods', {callback: callback});
        },
        computed:{
           
        },
        methods:{
        }
    }
</script>

<style>
    .chefContainer{
        padding-bottom: 75px;
    }
</style>