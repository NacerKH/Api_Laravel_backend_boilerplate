<template>

  <user-layout>
    <notifications  animation-type="velocity"/>
    <router-view />
  </user-layout>
</template>

<script>
import UserLayout from "../../../Layouts/UserLayout.vue";

export default {
  components: {
    "user-layout": UserLayout
  }
};
</script>
