<template>
    <ul class="flex items-center gap-2 2xsm:gap-4">

        <!-- Notification Menu Area -->
        <li class="relative">
            <a class="relative flex h-8.5 w-8.5 items-center justify-center rounded-full border-[0.5px] border-stroke bg-gray hover:text-primary dark:border-strokedark dark:bg-meta-4 dark:text-white"
                href="#" @click.prevent="() => { notifyingOpen = !notifyingOpen; notifying = !notifying }">
                <TranslateIcon class="fill-current duration-300 ease-in-out" width="18" height="18" />
            </a>

            <!-- Dropdown Start -->
            <div v-show="notifyingOpen"
                class="absolute -right-27 mt-2.5 flex h-40 w-30 flex-col rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark sm:right-0 sm:w-30">
                <div class="px-4.5 py-3">
                    <h5 class="text-lg font-bold uppercase text-center">-{{ getLang() }}-</h5>
                </div>
                <ul class="flex h-auto flex-col  overflow-y-auto">
                    <li v-for="lang, i in langs" :key="i">
                        <a class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4"
                            href="#" @click.prevent="changeLanguage(lang)">
                            <p class="text-lg text-center">
                                {{ lang }}
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Dropdown End -->
        </li>
        <!-- Notification Menu Area -->

    </ul>
</template>
<script setup lang="ts">
import TranslateIcon from '@/svg-components/TranslateIcon.vue';
import { ref } from 'vue'
const notifyingOpen = ref(false)
const notifying = ref(true)
const langs: Lang[] = ['es', 'en']

const changeLanguage = (lang: Lang) => {
    localStorage.setItem('lang', lang)
    window.location.reload()
}

type Lang = 'es' | 'en'

const getLang = (): string => {
    return localStorage.getItem('lang') ?? 'en'
}
</script>
