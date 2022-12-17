<template>
<div>
    <b-row>
        <b-colxx xxs="12">
            <piaf-breadcrumb :heading="$t('menu.UsersList')" />
            <div class="separator mb-5"></div>
        </b-colxx>
    </b-row>
    <b-row>
        <b-colxx xxs="12">
            <b-card class="mb-4" :title="$t('menu.users')">
                   <list :users="users"></list>
            </b-card>
        </b-colxx>
    </b-row>
</div>
</template>
<script setup>
import list from "../../ui/datatables/DividedTable.vue";
import useCrudUserService from"../../../../../services/user/crud/CrudUsersServices"
import { onMounted } from "@vue/runtime-core";
const {getUsers, users } =useCrudUserService();
onMounted(async ()=> {


   await  getUsers()
  return   users;
})


</script>
