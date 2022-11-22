<template>

    <div class="d-flex justify-content-center font-bold mt-4">
<h1>Welcome floks  </h1>

    </div>
    <h1 class="d-flex  p-2 justify-content-center font-bold mt-4">
        <router-link :to="'/user'" class="btn btn-primary">{{isLogged}}</router-link>
        <a class="btn btn-secondary" v-if="user" v-on:click="logout()">LogOut</a>
</h1>
</template>

<script setup>

import { computed } from 'vue';
import {getCurrentUser} from'../../utils'
import {UserRole} from'../../utils/auth.roles'
import {  mapActions } from '../../utils/map-state.js'
const {signOut} =mapActions();
 const user=getCurrentUser();


 const module = 'user';
 const isLogged=  computed(()=>{
     if(user != null || user != undefined)
{
    if( user.role==UserRole.Admin){
      return "You Are Logged Like Admin"
    }else{
        return "You Are Logged Like Client"
    }
}

return "Log In Please  "


 })


  console.log(signOut)
 const logout=()=>{
    signOut()
 }
</script>
