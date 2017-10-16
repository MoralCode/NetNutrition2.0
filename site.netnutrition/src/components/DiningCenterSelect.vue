<template>
    <div>
       <h4> Dining Centers </h4>
            <div class="form-group">
                <select v-model="selectedCenter" @click="centerSelected" class="form-control" id="sel1">
                    <option v-for="center in diningCenters">{{center.name}}</option>
                </select>
            </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                selectedCenter:""
            }
        },
        computed:{
            diningCenters() {
                 return this.$store.state.diningCenterData.diningCenters
            }
        },
        methods:{
            centerSelected(){
                if(this.selectedCenter !== ""){
                    this.$store.commit('selectDiningCenter', this.selectedCenter);
                    this.$router.push('/dining-center/'+ this.selectedCenter);
                   
                }
                 
            }
        },
        mounted() {
            
           
        }
    }
</script>
