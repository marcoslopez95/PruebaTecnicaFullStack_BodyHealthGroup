<template>
    <AppLayout>
        <div class="max-w-screen-2xl mx-auto p-4 md:p-6 2xl:p-10">
            <!-- Breadcrumb Start -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <h2 class="font-semibold text-title-md2 text-black dark:text-white">Table</h2>

                <nav>
                    <ol class="flex items-center gap-2">
                        <li><a href="index.html">Dashboard /</a></li>
                        <li class="text-primary">Table</li>
                    </ol>
                </nav>
            </div>
            <!-- Breadcrumb End -->

            <!-- ====== Table Section Start -->
            <div class="flex flex-col gap-10">
                <!-- ====== Table One Start -->
                <Table01 />
                <!-- ====== Table One End -->

                <!-- ====== Table Two Start -->
                <Table02 />
                <!-- ====== Table Two End -->

                <!-- ====== Table Three Start -->
                <Table03 />
                <!-- ====== Table Three End -->
            </div>
            <!-- ====== Table Section End -->
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import Table01 from './tables/Table1.vue';
import Table02 from './tables/Table2.vue';
import Table03 from './tables/Table3.vue';

</script>

<style scoped></style>
