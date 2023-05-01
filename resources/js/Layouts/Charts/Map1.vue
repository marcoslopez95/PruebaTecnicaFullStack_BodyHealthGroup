<template>
<div
  class="col-span-12 rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-default dark:border-strokedark dark:bg-boxdark xl:col-span-7">
  <h4 class="mb-2 text-xl font-bold text-black dark:text-white">
    Region labels
  </h4>
  <div id="mapOne" class="mapOne map-btn h-90"></div>
</div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import map01 from './map-01.js'

// export default chart01;
onMounted(() => {
    map01()
})
</script>

<style scoped></style>
