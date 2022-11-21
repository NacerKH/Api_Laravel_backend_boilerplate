<template>

    <div class="d-flex justify-content-center font-bold mt-4">
<h1>Welcome floks  </h1>

    </div>
    <h1 class="d-flex  p-2 justify-content-center font-bold mt-4">
        <router-link :to="'/user'" class="btn btn-primary">{{isLogged}}</router-link>
</h1>
</template>

<script setup>

import { computed } from 'vue';
import {getCurrentUser} from'../../utils'
import {UserRole} from'../../utils/auth.roles'
 const user=getCurrentUser();

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
</script>
