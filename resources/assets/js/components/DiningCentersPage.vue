<template>
    <div>
       <h3> Dining Centers </h3>
    
      <div class="list-group">
            <button v-for="center in diningCenters" type="button" class="list-group-item">
                 <h4>
                    <router-link :to="{ path: '/dining-center/' + center.name}">{{center.name}}</router-link>
                 </h4>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                diningCenters:[]
            }
        },

        mounted() {
            axios.get('http://netnutrition.dev/api/dining-list')
                    .then( response => {
                        this.diningCenters = response.data
                    })
        }
    }
</script>
