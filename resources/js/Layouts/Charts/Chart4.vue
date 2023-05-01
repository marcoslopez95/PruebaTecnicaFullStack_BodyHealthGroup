<template>
  <div
  class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
  <div>
    <h3 class="text-xl font-bold text-black dark:text-white">
      Visitors Analytics
    </h3>
  </div>
  <div>
    <div id="chartFour" class="-ml-5"></div>
  </div>
</div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import chart04 from './chart-04.js'

// export default chart01;
onMounted(() => {
    chart04()
})
</script>

<style scoped></style>
