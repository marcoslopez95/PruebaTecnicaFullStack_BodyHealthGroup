<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Preloader from './Preloader.vue'
import Sidebar from './Sidebar.vue'
import HeaderComponent from './HeaderComponent.vue'

import "~prims";
import "jsvectormap/dist/css/jsvectormap.css";
import "flatpickr/dist/flatpickr.min.css";
import "@/../css/style.css";
import flatpickr from "flatpickr";
// @ts-ignore
import Alpine from "alpinejs";
// @ts-ignore
import intersect from "@alpinejs/intersect";

defineProps<{title: string}>();

const loading = ref(true)

onMounted(() => {
    setTimeout(() => {
        loading.value = false
    }, 300);
})

Alpine.plugin(intersect);
// window.Alpine = Alpine;
Alpine.start();

// Init flatpickr
flatpickr(".datepicker", {
    mode: "range",
    static: true,
    monthSelectorType: "static",
    dateFormat: "M j, Y",
    defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
    prevArrow:
        '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
    nextArrow:
        '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
    onReady: (selectedDates, dateStr, instance) => {
        // eslint-disable-next-line no-param-reassign
        // @ts-ignore
        instance.element.value = dateStr.replace("to", "-");
        const customClass = instance.element.getAttribute("data-class");
        // @ts-ignore

        instance.calendarContainer.classList.add(customClass);
    },
    onChange: (selectedDates, dateStr, instance) => {
        // eslint-disable-next-line no-param-reassign
        // @ts-ignore
        instance.element.value = dateStr.replace("to", "-");
    },
});

</script>

<template>
    <div>

        <Head :title="title" />

        <!-- <Banner /> -->

        <Preloader v-if="loading" />

        <!-- ===== Page Wrapper Start ===== -->
        <div class="flex h-screen overflow-hidden">
            <!-- ===== Sidebar Start ===== -->
            <Sidebar />
            <!-- ===== Sidebar End ===== -->

            <!-- ===== Content Area Start ===== -->
            <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
                <!-- ===== Header Start ===== -->
                <HeaderComponent
                    >
                </HeaderComponent>
                <!-- ===== Header End ===== -->

                <!-- ===== Main Content Start ===== -->
                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>

                <!-- ===== Main Content End ===== -->
            </div>
            <!-- ===== Content Area End ===== -->
        </div>
        <!-- ===== Page Wrapper End ===== -->
    </div>
</template>
