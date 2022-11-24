<template>
  <b-card :title="$t('dashboards.recent-orders')">
    <b-refresh-button @click="refreshButtonClick" />
    <PerfectScrollbar
      class="scroll dashboard-list-with-thumbs"
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
    >
      <recent-order-item
        v-for="(order,index) in products.slice(0,6)"
        :order="order"
        detail-path="#"
        :key="index"
      />
    </PerfectScrollbar>
  </b-card>
</template>
<script>
import RecentOrderItem from "../../components/Listing/RecentOrderItem.vue";
import products from "../../data/products";

export default {
  components: {
    "recent-order-item": RecentOrderItem
  },
  data() {
    return {
      products
    };
  },
  methods: {
    refreshButtonClick() {
      console.log("refreshButtonClick");
    }
  }
};
</script>
