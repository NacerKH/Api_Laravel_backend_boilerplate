

<template>
<LayoutHome>
    <div class="d-flex justify-content-center font-bold mt-4">
<h1>Welcome floks  </h1>

    </div>
    <h1 class="d-flex  p-2 justify-content-center font-bold mt-4">
        <router-link :to="'/user'" class="btn btn-primary">{{isLogged}}</router-link>
        <a class="btn btn-secondary" v-if="user" v-on:click="logout()">LogOut</a>
</h1>
</LayoutHome>
</template>

<script setup>
import LayoutHome from '../../Layouts/HomeLayout.vue'
import router from '@/router';
import { computed, onMounted, onUnmounted, watch, watchEffect } from 'vue';


import {getCurrentUser} from'../../utils'
import {UserRole} from'../../utils/auth.roles'
import {  mapActions,mapGetters } from '../../utils/map-state.js'
const {signOut} =mapActions();
const {currentUser} =mapGetters();
 const user=getCurrentUser();


 const module = 'user';

 const isLogged=  computed(()=>{
    if ((user != null || user != undefined)){
        return   user.role==UserRole.Admin?"You Are Logged Like Admin":"You Are Logged Like Client"

    }
  return "Log In Please  "


 })

 watch(currentUser, async (newvalue, value) => {

    if ( !newvalue || newvalue.id==null || newvalue == undefined) {
                    setTimeout(() => {
                        location.reload();
                    }, 200);
                }

    })

 const logout=()=>{
    signOut()
 }
</script>
