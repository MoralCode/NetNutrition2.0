<template>
    <div>
       <h4> Dining Centers </h4>
            <hr>
            <div v-for="center in diningCenters">
                 <h6>
                    <router-link :to="{ path: '/dining-center/' + center.name}">{{center.name}}</router-link>
                 </h6>
                 <hr>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                
            }
        },
        computed:{
            diningCenters() {
                 return this.$store.state.diningCenterData.diningCenters
            }
        },
        mounted() {
           
        }
    }
</script>
