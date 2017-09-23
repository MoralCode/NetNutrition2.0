<template>
    <div>
        <h4> Hello, Kyle! </h4>
         <h4> September 23, 2017 </h4>

         <div class="panel panel-default">
            <div class="panel-body">
                <h4> 2000/2700 Calories </h4>
                    <ul>
                        <li> 30/60 Fat</li>
                        <li> 200/300 Carbs</li>
                        <li> 120/150 Protein</li>
                    </ul>
            </div>
        </div>

        <button type="button" class="btn btn-success">
            <router-link to="/food-log">View Food Log</router-link>
        </button>

          <button type="button" class="btn btn-primary">
            <router-link to="/dining-centers">+Add Food</router-link>
        </button>
        
       
    </div>
</template>

<script>
    export default {
        name:'dining-centers-page',
        mounted() {
            console.log('Dining centers')
        }
    }
</script>

<style>
      button a {
        color:white;
    }
</style>
