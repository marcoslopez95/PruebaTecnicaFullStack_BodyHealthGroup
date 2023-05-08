<template>
    <AppLayout>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
          <!-- Breadcrumb Start -->
          <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
              Chart
            </h2>

            <nav>
              <ol class="flex items-center gap-2">
                <li><a class="font-medium" href="index.html">Dashboard /</a></li>
                <li class="font-medium text-primary">Chart</li>
              </ol>
            </nav>
          </div>
          <!-- Breadcrumb End -->

          <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
            <!-- ====== Chart Four Start -->
            <div class="col-span-12">
              <Chart4 />
            </div>
            <!-- ====== Chart Four End -->

            <!-- ====== Chart One Start -->
            <Chart1 />
            <!-- ====== Chart One End -->

            <!-- ====== Chart Two Start -->
            <Chart2 />
            <!-- ====== Chart Two End -->

            <!-- ====== Chart Three Start -->
            <Chart3 />
            <!-- ====== Chart Three End -->
          </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import Chart1 from '@/Layouts/Charts/Chart1.vue';
import Chart2 from '@/Layouts/Charts/Chart2.vue';
import Chart3 from '@/Layouts/Charts/Chart3.vue';
import Chart4 from '@/Layouts/Charts/Chart4.vue';


</script>

<style scoped>

</style>
