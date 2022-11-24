<template>
  <b-card :title="$t('dashboards.new-comments')" class="dashboard-link-list">
    <PerfectScrollbar
      class="scroll dashboard-list-with-user"
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
    >
      <list-with-user-item
        v-for="(item, index) in comments"
        :data="item"
        detail-path="#"
        :key="index"
      />
    </PerfectScrollbar>
  </b-card>
</template>
<script>
import ListWithUserItem from "../../components/Listing/ListWithUserItem.vue";
import { comments } from "../../data/comments";

export default {
  components: {
    "list-with-user-item": ListWithUserItem
  },
  data() {
    return {
      comments
    };
  }
};
</script>
