<template>
    <div>
        <div class="form-group">
            <label class="diningcenterLabel">Dining Center: </label>
            <select v-model="selectedCenter" @click="centerSelected" class="form-control diningcenterDropdown" id="sel1">
                <option disabled hidden value="">Select Dining Center</option>
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
<style>
    .diningcenterLabel{
        float:left;
        margin-right:1em;
        font-size:16px;
        padding-top:6px;
        padding-bottom:6px;
    }
    .diningcenterDropdown{
        width:60%; 
    }
</style>
