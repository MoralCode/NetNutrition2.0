<template>
    <div>
     
       <h3> Dining Centers </h3>
    
            <hr>
            <div v-for="center in diningCenters">
                 <h4>
                    <router-link :to="{ path: '/dining-center/' + center.name}">{{center.name}}</router-link>
                 </h4>
                 <hr>
            </div>
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
