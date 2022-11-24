<template>
  <b-card :title="$t('dashboards.tickets')">
    <PerfectScrollbar
      class="scroll dashboard-list-with-user"
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
    >
      <list-with-user-item
        v-for="(ticket, index) in tickets"
        :data="ticket"
        detail-path="#"
        :key="index"
      />
    </PerfectScrollbar>
  </b-card>
</template>
<script>
import ListWithUserItem from "../../components/Listing/ListWithUserItem.vue";
import tickets from "../../data/tickets";

export default {
  components: {
    "list-with-user-item": ListWithUserItem
  },
  data() {
    return {
      tickets
    };
  }
};
</script>
