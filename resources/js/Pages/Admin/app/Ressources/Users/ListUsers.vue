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
                   <list></list>
            </b-card>
        </b-colxx>
    </b-row>
</div>
</template>
<script setup>
import list from "../../ui/datatables/DividedTable.vue";
</script>
