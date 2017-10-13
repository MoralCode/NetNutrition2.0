<template>
    <div>
        <datepicker v-model="date" v-on:selected ="storeDate"></datepicker>
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
