<template>
    <div>
        
        <div @click="setDate">
            <h1>ON THE PAGE?</h1>
            <datepicker ref="dp" v-model="dateValue" placeholder=""></datepicker>
        </div>
        
    </div>
</template>

<script>
    export default {
        data(){
          return{
              dateValue: new Date().toLocaleDateString()
          }
        },
        watch:{
            getDate: function(){
                this.dateValue = this.$store.state.date.toLocaleDateString();
            }
        },
        methods:{
            setDate: function(){
                this.$store.commit('setDate',new Date(this.$refs.dp.parse()));
            }
        },
        mounted() {

            this.$store.commit('setDate', new Date());

        },
    }
</script>
