<template>
    <div>
       <h3> Login </h3>
            <div class="form-group">
                <label for="netid">Your netid</label>
                <input type="email" class="form-control" id="netid" placeholder="netid">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button @click="login"  class="btn btn-primary">Login</button>
       
    </div>
</template>

<script>
    export default {
        food(){
            return{
              
            }
        },
        computed:{
       
        },
        methods:{
            login: function() {
                this.$store.dispatch('login')
            }
          
        },
        mounted(){
           
        }
    }
</script>
<style>

</style>