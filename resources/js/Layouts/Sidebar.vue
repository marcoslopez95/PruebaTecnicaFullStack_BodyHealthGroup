<template>
    <aside
  :class="openHamburgerMenu ? 'translate-x-0' : '-translate-x-full'"
  class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
  @click.outside="openHamburgerMenu = false"
>
  <!-- SIDEBAR HEADER -->
  <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
    <a
    :href="// @ts-ignore
        route('dashboard')"
        >
      <img src="/images/logo/logo.svg" alt="Logo" />
    </a>

    <button
      class="block lg:hidden"
      @click.stop="openHamburgerMenu = !openHamburgerMenu"
    >
      <BurguerComponent />
    </button>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear"
  >
    <!-- Sidebar Menu -->
    <nav
      class="mt-5 py-4 px-4 lg:mt-9 lg:px-6"

    >
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MENU</h3>

        <ul class="mb-6 flex flex-col gap-1.5">
          <!-- Menu Item Dashboard -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="#"
              @click.prevent="clickInDropdownMenu('Dashboard')"
              :class="[
                // @ts-ignore
                verifiedActiveItemMenu('dashboard','analytics') ?'bg-graydark dark:bg-meta-4' : '',
                ]"

            >

              <DashboardIcon />

              Dashboard

              <ArrowIcon
                :class="{ 'rotate-180': (selected === 'Dashboard') }"
              />
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden"
              :class="(selected === 'Dashboard') ? 'block' :'hidden'"
            >
              <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    :href="// @ts-ignore
                    route('dashboard')"
                    :class="
                        // @ts-ignore
                        route().current('dashboard') ? '!text-white':''"
                    >Analytics</a
                  >
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Dashboard -->

          <!-- Menu Item Calendar -->
          <li>

            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              :href="
              //@ts-ignore
              route('calendar')
              "
              @click="clickInDropdownMenu('Calendar')"
              :class="{ 'bg-graydark dark:bg-meta-4': verifiedActiveItemMenu('calendar')}"
            >

              <CalendarIcon />

              Calendar
            </a>
          </li>
          <!-- Menu Item Calendar -->

          <!-- Menu Item Profile -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              :href="/*@ts-ignore*/
                route('profile')"
                @click="clickInDropdownMenu('Profile')"
                :class="[
                verifiedActiveItemMenu('profile') ?'bg-graydark dark:bg-meta-4' :'',
                ]"
            >
              <ProfileIcon />

              Profile
            </a>
          </li>
          <!-- Menu Item Profile -->

          <!-- Menu Item Forms -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="#"
              @click.prevent="clickInDropdownMenu('Forms')"
              :class="{ 'bg-graydark dark:bg-meta-4': verifiedActiveItemMenu('Forms','formElements', 'formLayout') }"
            >
              <FormIcon />

              Forms

              <ArrowIcon
                :class="{ 'rotate-180': (selected === 'Dashboard') }"
              />
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden"
              :class="(selected === 'Forms') ? 'block' :'hidden'"
            >
              <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    :href="//@ts-ignore
                    route('formElements')"
                    :class="verifiedActiveItemMenu('formElements' ) ? '!text-white': ''"
                    >Form Elements</a
                  >
                </li>
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    href="form-layout.html"
                    :class="verifiedActiveItemMenu( 'formLayout') ? '!text-white':''"
                    >Form Layout</a
                  >
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Forms -->

          <!-- Menu Item Tables -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="tables.html"
              @click="selected = (selected === 'Tables' ? '':'Tables')"
              :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Tables') && (page === 'Tables') }"
            >
              <TableIcon />

              Tables
            </a>
          </li>
          <!-- Menu Item Tables -->

          <!-- Menu Item Settings -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="settings.html"
              @click="selected = (selected === 'Settings' ? '':'Settings')"
              :class="[
                (selected === 'Settings') && (page === 'settings') ? 'bg-graydark dark:bg-meta-4': ''
                ]"

            >
              <SettingIcon />

              Settings
            </a>
          </li>
          <!-- Menu Item Settings -->
        </ul>
      </div>

      <!-- Others Group -->
      <div>
        <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">OTHERS</h3>

        <ul class="mb-6 flex flex-col gap-1.5">
          <!-- Menu Item Chart -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="chart.html"
              @click="selected = (selected === 'Chart' ? '':'Chart')"
              :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Chart') && (page === 'Chart') }"
            >
              <ChartIcon />

              Chart
            </a>
          </li>
          <!-- Menu Item Chart -->

          <!-- Menu Item Ui Elements -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="#"
              @click.prevent="selected = (selected === 'UiElements' ? '':'UiElements')"
              :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'UiElements') || (page === 'alerts' || page === 'buttons' || page === 'card' || page === 'tabs' || page === 'modals') }"
            >
              <Gridcolspan />

              UI Elements

              <ArrowIcon
                :class="{ 'rotate-180': (selected === 'Dashboard') }"
              />
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden"
              :class="(selected === 'UiElements') ? 'block' :'hidden'"
            >
              <ul class="mt-4 mb-3 flex flex-col gap-2 pl-6">
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    href="alerts.html"
                    :class="page === 'alerts' && '!text-white'"
                    >Alerts</a
                  >
                </li>
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    href="buttons.html"
                    :class="page === 'buttons' && '!text-white'"
                    >Buttons</a
                  >
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Ui Elements -->

          <!-- Menu Item Auth Pages -->
          <li>
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              href="#"
              @click.prevent="selected = (selected === 'AuthPages' ? '':'AuthPages')"
              :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'AuthPages') || (page === 'register' || page === 'login' || page === 'forgetPassword') }"
            >
              <AuthIcon />

              Authentication

              <ArrowIcon
                :class="{ 'rotate-180': (selected === 'Dashboard') }"
              />
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden"
              :class="(selected === 'AuthPages') ? 'block' :'hidden'"
            >
              <ul class="mt-4 mb-3 flex flex-col gap-2 pl-6">
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    href="signin.html"
                    :class="page === 'signin' && '!text-white'"
                    >Sign In</a
                  >
                </li>
                <li>
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    href="signup.html"
                    :class="page === 'signup' && '!text-white'"
                    >Sign Up</a
                  >
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Auth Pages -->
        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->

    <!-- Promo Box -->
    <!-- <div
      class="mx-auto mb-10 w-full max-w-60 rounded-sm border border-strokedark bg-boxdark py-6 px-4 text-center shadow-default">
      <h3 class="mb-1 font-semibold text-white">TailAdmin Pro</h3>
      <p class="mb-4 text-xs">Get All Dashboards and 300+ UI Elements</p>
      <a href="https://tailadmin.com/pricing" target="_blank" rel="nofollow"
        class="flex items-center justify-center rounded-md bg-primary p-2 text-white hover:bg-opacity-95">
        Purchase Now
      </a>
    </div> -->
    <!-- Promo Box -->
  </div>
</aside>

</template>

<script setup lang="ts">
import { helperStore } from '@/helper';
import {  ref } from 'vue';
import { storeToRefs } from 'pinia'
import DashboardIcon from '~icons/dashboardIcon.vue';
import ArrowIcon from '~icons/ArrowIcon.vue';
import CalendarIcon from '~icons/CalendarIcon.vue'
import ProfileIcon from '~icons/ProfileIcon.vue'
import FormIcon from '~icons/FormIcon.vue'
import TableIcon from '~icons/TableIcon.vue'
import SettingIcon from '~icons/SettingIcon.vue'
import ChartIcon from '~icons/ChartIcon.vue'
import Gridcolspan from '~icons/Gridcolspan.vue'
import AuthIcon from '~icons/AuthIcon.vue'
import BurguerComponent from '~icons/BurguerComponent.vue'

const selected = ref('')
const page = ref('')
// const openHamburgerMenu = inject('openHamburgerMenu')
const helper = helperStore()

const { openHamburgerMenu } = storeToRefs(helper)

const clickInDropdownMenu = (item:string):void => {
    selected.value = selected.value === item ? '' : item
}

const verifiedActiveItemMenu = (...items: string[]): boolean => {
    let band = false
    items.forEach(item =>{
        // @ts-ignore
        if(route().current(item)){
            band = true
        }
    })
    return band
}

interface ItemMenu {
    label:string
    to: string
    icon: Blob
    children?: ItemMenu[]
}
</script>

<style scoped>

</style>
