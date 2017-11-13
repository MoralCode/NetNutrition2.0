<template>
    <div>
       <h3> Login </h3>
            <div class="form-group">
                <label for="netid">Your netid</label>
                <input v-model="username" type="email" class="form-control" id="netid" placeholder="netid">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input  v-model="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button @click="attemptLogin"  class="btn btn-primary">Login</button>
       
    </div>
</template>

<script>
    export default {
        data(){
            return{
                username:'',
                password:''

            }
        },
     
        methods:{
            attemptLogin: function() {
                this.$store.dispatch('attemptLogin', {username:this.username, password:this.password})
            }
          
        },
        mounted(){
           
        }
    }
</script>
<style>

</style>