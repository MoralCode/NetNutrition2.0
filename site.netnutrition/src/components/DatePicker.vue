<template>
    <div id="datepickerContainer">
        <div class="dateLabel">Date: </div>
        <datepicker input-class="datepickerInput" v-model="date" v-on:selected ="storeDate"></datepicker>
    </div>
</template>

<script>

    export default {
        data(){
          return{
              date:new Date()
          }
        },
        mounted(){
           this.$store.commit('setDate', new Date());
        },
        methods:{
            storeDate:function(event){
                this.$store.commit('setDate', this.date);
            }
        },
        computed:{
            selectedDate: function(){
                return this.$store.getters.selectDate;
            }
        }
        
    }
</script>
<style>
    
    .dateLabel{
        float:left;
        margin-right:1em;
        font-size:16px;
    }
</style>
