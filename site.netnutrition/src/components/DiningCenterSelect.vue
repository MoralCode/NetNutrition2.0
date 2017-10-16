<template>
    <div>
       <h4> Dining Centers </h4>
            <div class="form-group">
                <label for="sel1">Select list:</label>
                <select v-model="selectedCenter" @click="changeRoute" class="form-control" id="sel1" >
                    <option selected disabled>Pick Dining Center</option>
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
            changeRoute(){
                if(this.selectedCenter !== ""){
                    //console.log("watched");
                    this.$router.push('/dining-center/'+ this.selectedCenter);
                }
                 
            }
        },
        mounted() {
           
        }
    }
</script>
