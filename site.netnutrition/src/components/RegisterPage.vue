<template>
    <div>
       <h3> Register </h3>
            <div class="form-group">
                <label for="netid">Your netid</label>
                <input v-model="username" type="email" class="form-control" id="netid" placeholder="netid">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input  v-model="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
             <div class="form-group">
                <label for="password">Confirm Password</label>
                <input  v-model="confirmPassword" type="password" class="form-control" id="password" placeholder=" Confirm Password">
            </div>
            <span style='color:red' v-if="!usernameLength"> net_id must be at least 5 characters  <br> </span>
            <span style='color:red' v-if="!passwordsMatch"> Confirmed password does not match password <br></span> 
            <span style='color:red' v-if="!passwordLength"> Password must be 8 characers or longer <br> </span>

            <button :disabled="!(passwordsMatch && passwordLength)" @click="attemptRegister"  class="btn btn-primary">Register</button> <br>
             <h6> <router-link to="/login"> Already a member? click here to login </router-link> </h6>
              <span style='color:red' v-if="registerFail"> Username is taken <br> </span>
       
    </div>
</template>

<script>
    export default {
        data(){
            return{
                username:'',
                password:'',
                confirmPassword:''
                
            }
        },

        computed:{
            passwordsMatch(){
                return this.password == this.confirmPassword
            },
            passwordLength(){
                return this.password.length >= 8
            },
            usernameLength(){
                return this.username.length >= 5
            },
            registerFail(){
                return this.$store.state.registerFail
            }
        },
     
        methods:{
            attemptRegister: function() {
                this.$store.dispatch('attemptRegister', {username:this.username, password:this.password, confirmPassword: this.confirmPassword})
            }
          
        },
        mounted(){
           
        }
    }
</script>
<style>

</style>