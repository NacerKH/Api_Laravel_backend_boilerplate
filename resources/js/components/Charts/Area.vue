<template>
  <div :class="containerClass">
    <canvas ref="chart"></canvas>
  </div>
</template>
<script setup>

import { Chart, LineController } from 'chart.js/auto';
import { CustomLineController} from './CustomLineController.js';


import { areaChartOptions } from "./config";
import { onMounted, ref } from "vue";
     const chart = ref(null);

     Chart.register(CustomLineController);


const props =defineProps({
    data: {
      type: Object
    },
    containerClass: {
      type: String,
      default: "chart-container"
    },
    shadow: {
      type: Boolean,
      default: false
    }})

  onMounted(()=>{
    CustomLineController.id = 'shadow';
CustomLineController.defaults = LineController.defaults;

// Stores the controller so that the chart initialization routine can look it up
Chart.register(CustomLineController);
    const ctx = chart.value;
    new Chart(ctx, {
    type: 'shadow',
    data: props.data,

    options: areaChartOptions
  });
}
)


//  const ctx = this.$refs.chart;
//     const myChart = new Chart(ctx, {
//       type: this.shadow ? "lineWithShadow" : "line",
//       data: this.data,
//       options: areaChartOptions
//     });
    // if (this.shadow) {
    //   Chart.defaults.lineWithShadow = Chart.overrides.line;
    //   Chart.controllers.lineWithShadow = LineController.extend({
    //     draw(ease) {
    //       Chart.controllers.line.prototype.draw.call(this, ease);
    //       const chartCtx = this.chart.ctx;
    //       chartCtx.save();
    //       chartCtx.shadowColor = "rgba(0,0,0,0.15)";
    //       chartCtx.shadowBlur = 10;
    //       chartCtx.shadowOffsetX = 0;
    //       chartCtx.shadowOffsetY = 10;
    //       chartCtx.responsive = true;
    //       chartCtx.stroke();
    //       Chart.controllers.line.prototype.draw.apply(this, arguments);
    //       chartCtx.restore();
    //     }
    //   });
    // }
    // const ctx = this.$refs.chart;
    // const myChart = new Chart(ctx, {
    //   type: this.shadow ? "lineWithShadow" : "line",
    //   data: this.data,
    //   options: areaChartOptions
    // });
//   }

</script>
