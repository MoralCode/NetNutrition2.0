<template>
    <div class="container adminContainer">
    
        <ul class="nav nav-pills adminNav">
            <li class="active" @click="setTab('user')"><a data-toggle="pill">Users</a></li>
        </ul>   

        <div class="tab-content">

        <!--USER INFORMATION TAB-->
            <div v-if="tab=='user'">
                <div class = "noOfUsers"><h5>Number of Users:  {{users.length}}</h5></div>
                <ul class="list-group">
                    <li class="list-group-item" v-for="user in users">
                        <div v-if="userEdit != user.id">
                            <strong>User ID:  </strong>{{user.net_id}}
                            <br>
                            <strong>Created At:  </strong>{{user.created_at}}
                            <br>
                            <strong>Sesssion Expires:  </strong>{{(user.api_token_expiration || "").substr(0, 11)}} | {{(user.api_token_expiration || "").substr(12, 22)}}
                            <br>
                            <strong>Role:  </strong>{{user.role.name}}
                            <br>
                            <div class="btn-group">
                                <button class="btn btn-default adminBtn" @click="setUserEdit(user.id)">EDIT</button>
                                <button class="btn btn-danger adminBtn" @click="deleteUser(user.id)">DELETE</button>
                            </div>
                            
                        </div>
                        <div v-if="userEdit == user.id">
                            <label for="net_id">User ID</label>
                            <input :id="user.id + 'net_id_input'" :value="user.net_id" type="text" class="form-control" name="net_id">
                            <label for="role_id">Role</label>
                            <select :id="user.id + 'role_id_input'" :value="user.role_id" class="form-control" name="role_id">
                                <option value="1">Admin</option>
                                <option value="2">Chef</option>
                                <option value="3">Student</option>
                            </select>
                            <br>
                            <button class="btn btn-default" @click="setUserEdit('')">BACK</button>
                            <button class="btn btn-success" @click="submitEdit(user.id)">SUBMIT</button>
                        </div>
                        
                    </li>
                </ul>
            </div>




        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    export default {
        data(){
          return{
             tab:'',
             userEdit: 0,
             edittingUser:""
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
               console.log(this.$store.state.users);
               this.tab = tab;
           },
           setUserEdit(id){
               this.userEdit = id;
           },
           submitEdit(id){
               var net_id = document.getElementById(id + 'net_id_input').value;
               var role_id = document.getElementById(id + 'role_id_input').value;

               var callback = ()=>{
                   this.$store.dispatch('getUsers');
                   this.setUserEdit('');
                }

               this.$store.dispatch('editUser', {id: id, net_id: net_id, role_id: role_id, callback: callback});
               
           },
           deleteUser(id){
                var callback = ()=>{
                   this.$store.dispatch('getUsers');
                   this.setUserEdit('');
                }
               this.$store.dispatch('deleteUser',{id: id, callback: callback});
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
    .adminBtn{
        margin: 10px;
    }
</style>

