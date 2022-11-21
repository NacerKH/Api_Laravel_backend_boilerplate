<template>
  <app-layout>
    <router-view />
  </app-layout>
</template>

<script>
import AppLayout from "../../../Layouts/AppLayout.vue";

export default {
  components: {
    "app-layout": AppLayout
  }
};
</script>
