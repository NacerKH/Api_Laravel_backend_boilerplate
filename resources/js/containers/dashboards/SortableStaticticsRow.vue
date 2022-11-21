<template>
<draggable class="row">
      <b-colxx xl="3" lg="6" class="mb-4">
        <radial-progress-card :title="$t('dashboards.payment-status')" :percent="64" />
      </b-colxx>
      <b-colxx xl="3" lg="6" class="mb-4">
        <radial-progress-card :title="$t('dashboards.work-progress')" :percent="75" />
      </b-colxx>
      <b-colxx xl="3" lg="6" class="mb-4">
        <radial-progress-card :title="$t('dashboards.tasks-completed')" :percent="32" />
      </b-colxx>
      <b-colxx xl="3" lg="6" class="mb-4">
        <radial-progress-card :title="$t('dashboards.payments-done')" :percent="45" />
      </b-colxx>
    </draggable>
</template>
<script>
  import { defineComponent } from 'vue'
import { VueDraggableNext } from "vue-draggable-next";
import RadialProgressCard from "../../components/Cards/RadialProgressCard.vue";
export default defineComponent( {
  components:{
     draggable: VueDraggableNext,
    "radial-progress-card": RadialProgressCard,
  }
})
</script>
