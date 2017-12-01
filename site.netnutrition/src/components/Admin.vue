<template>
    <div class="container adminContainer">
    
        <ul class="nav nav-pills adminNav">
            <li class="active" @click="setTab('user')"><a data-toggle="pill">Users</a></li>
            <li class="active" @click="setTab('mostEaten')"><a data-toggle="pill">IDk Yet</a></li>
            <li class="active" @click="setTab('user')"><a data-toggle="pill">Stats?</a></li>
        </ul>   

        <div class="tab-content">
            <div v-if="tab=='user'">
                <div class = "noOfUsers"><strong>No. of Users:  </strong>{{users.length}}</div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="user in users">
                        <strong>User ID:  </strong>{{user.net_id}}
                        <br>
                        <strong>Created At:  </strong>{{user.created_at}}
                        <br>
                        <strong>Sesssion Expires:  </strong>{{user.api_token_expiration.substr(0, 11)}} | {{user.api_token_expiration.substr(12, 22)}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
          return{
             tab:''
          }
        },
        mounted(){
            if(this.$store.state.role != "Admin"){
                this.$router.replace('/home');
            }
            //blame kyle
            this.$store.dispatch('getUsers');
            
           
        },
        methods:{
           setTab(tab){
               this.tab = tab;
           }
        },
        computed:{
            users(){
                return this.$store.state.users;
            }
        }
        
    }
</script>
<style>
    .adminNav{
        padding:10px;
    }

    .adminContainer{
        padding-bottom:80px;
    }
    .noOfUsers{
        padding: 10px;
    }
</style>

