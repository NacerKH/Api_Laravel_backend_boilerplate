<template>
  <b-card :title="$t('dashboards.logs')">
    <PerfectScrollbar
      class="dashboard-logs scroll"
      :settings="{ suppressScrollX: true, wheelPropagation: false }"
    >
      <log-list :logs="logs" />
    </PerfectScrollbar>
  </b-card>
</template>
<script>
import LogList from "../../components/Listing/LogList.vue";
import logs from "../../data/logs";

export default {
  components: {
    "log-list": LogList
  },
  data() {
    return {
      logs
    };
  }
};
</script>
