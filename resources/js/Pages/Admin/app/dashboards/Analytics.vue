<template>
  <div>
    <b-row>
      <b-colxx xxs="12">
        <piaf-breadcrumb :heading="$t('menu.analytics')" />
        <div class="separator mb-5"></div>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx sm="12" md="6" class="mb-4">
        <website-visit-chart-card></website-visit-chart-card>
      </b-colxx>
      <b-colxx sm="12" md="6" class="mb-4">
        <converconversion-rates-chart-card></converconversion-rates-chart-card>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx xl="4" lg="6" md="12" class="mb-4">
        <product-categories-doughnut></product-categories-doughnut>
      </b-colxx>
      <b-colxx xl="4" lg="6" md="12" class="mb-4">
        <profile-statuses></profile-statuses>
      </b-colxx>
      <b-colxx xl="4" lg="12" md="12">
        <small-line-charts itemClass="dashboard-small-chart-analytics"></small-line-charts>
      </b-colxx>
    </b-row>
    <sortable-statictics-row></sortable-statictics-row>
    <b-row>
      <b-colxx lg="6" xxs="12" class="mb-4">
        <order-stock-radar-chart></order-stock-radar-chart>
      </b-colxx>
      <b-colxx lg="6" xxs="12" class="mb-4">
        <product-categories-polar-area></product-categories-polar-area>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx xxs="12" class="mb-4">
        <sales-chart-card></sales-chart-card>
      </b-colxx>
    </b-row>
  </div>
</template>

<script>
import ConversionRatesChartCard from "../../../../containers/dashboards/ConversionRatesChartCard.vue";
import OrderStockRadarChart from "../../../../containers/dashboards/OrderStockRadarChart.vue";
import ProductCategoriesDoughnut from "../../../../containers/dashboards/ProductCategoriesDoughnut.vue";
import ProductCategoriesPolarArea from "../../../../containers/dashboards/ProductCategoriesPolarArea.vue";
import ProfileStatuses from "../../../../containers/dashboards/ProfileStatuses.vue";
import SalesChartCard from "../../../../containers/dashboards/SalesChartCard.vue";
import SmallLineCharts from "../../../../containers/dashboards/SmallLineCharts.vue";
import SortableStaticticsRow from "../../../../containers/dashboards/SortableStaticticsRow.vue";
import WebsiteVisitsChartCard from "../../../../containers/dashboards/WebsiteVisitsChartCard.vue";

export default {
  components: {
    "converconversion-rates-chart-card": ConversionRatesChartCard,
    "order-stock-radar-chart": OrderStockRadarChart,
    "product-categories-doughnut": ProductCategoriesDoughnut,
    "product-categories-polar-area": ProductCategoriesPolarArea,
    "profile-statuses": ProfileStatuses,
    "sales-chart-card": SalesChartCard,
    "small-line-charts": SmallLineCharts,
    "sortable-statictics-row": SortableStaticticsRow,
    "website-visit-chart-card": WebsiteVisitsChartCard
  }
};
</script>
