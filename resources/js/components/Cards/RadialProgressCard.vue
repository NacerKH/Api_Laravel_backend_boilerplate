<template>
<b-card no-body>
    <b-card-header class="p-0 position-relative" v-if="noSuffle!=false">
        <div class="position-absolute handle card-icon">
            <i class="simple-icon-shuffle" />
        </div>
    </b-card-header>
    <b-card-body class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0 card-title">{{ title }}</h5>
        <div class="progress-bar-circle">
            <radial-progress-bar      :is-bg-shadow="true"
      :bg-shadow="{
        inset: true,
        vertical: 2,
        horizontal: 2,
        blur: 10,
        opacity: .4,
        color: '#000000'
    }"
      empty-color="#f7f7f7"
      :border-width="6"
      :border-bg-width="30"   :size="100" :is-gradient="true"  :show-percent="true"   :percent="percent" >{{progressText}}</radial-progress-bar>
            <!-- <radial-progress-bar :diameter="54" :strokeWidth="2" :completed-steps="percent" :total-steps=100>{{percent}}%</radial-progress-bar> -->
        </div>
    </b-card-body>
</b-card>
</template>

<script>
import "vue3-circle-progress/dist/circle-progress.css";
import RadialProgressBar from "vue3-circle-progress";
export default {
    props: ['title', 'percent', 'noSuffle'],
    components: {
        'radial-progress-bar' : RadialProgressBar
    }
}
</script>
