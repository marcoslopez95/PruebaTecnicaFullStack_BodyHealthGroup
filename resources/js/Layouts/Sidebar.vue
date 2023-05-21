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
      <div v-for="menu,i in itemsMenu" :key="i">
        <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2 uppercase">{{menu.title}}</h3>

        <ul class="mb-6 flex flex-col gap-1.5">
          <!-- Menu Item Dashboard -->
          <li v-for="item,k in menu.items" :key="k">
            <a
              class="group relative flex items-center gap-2.5 rounded-sm py-2 px-4 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
              :href="item.children ?'#' : //@ts-ignore
              route(item.to)"
              @click="clickInDropdownMenu($event,item)"
              :class="{
                'bg-graydark dark:bg-meta-4': verifiedActiveItemMenu(...getAllToForItem(item)),
                }"

            >
            <Component v-if="item.icon" :is="item.icon" />
            {{ item.label }}
            <ArrowIcon
                v-if="item.children"
                :class="{ 'rotate-180': (selected === item.label) }"
              />


            </a>
             <!-- Dropdown Menu Start -->
             <div
            v-if="item.children"
              class="overflow-hidden"
              :class="(selected === item.label) ? 'block' :'hidden'"
            >
              <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
                <li v-for="child,j in item.children" :key="j">
                  <a
                    class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                    :href="// @ts-ignore
                    route(child.to)"
                    :class="
                        // @ts-ignore
                        {'!text-white' : route().current(child.to)}"
                    >{{child.label}}</a
                  >
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>

    </nav>

  </div>
</aside>

</template>

<script setup lang="ts">
import { helperStore } from '@/helper';
import {   DefineComponent, ref } from 'vue';
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
import { Link, router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import SecurityIcon from '@/svg-components/SecurityIcon.vue';
const { t } = useI18n()
const selected = ref('')
const page = ref('')
const helper = helperStore()

const { openHamburgerMenu } = storeToRefs(helper)

const clickInDropdownMenu = (e:Event,item:ItemMenu):void => {
    if(item.to==='#'){
        e.preventDefault()
    }
    const label = item.label
    selected.value = selected.value === label ? '' : label
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

const getAllToForItem = (element: ItemMenu): string[] =>{
    if(!element.children) return [...element.label]

    return element.children.map((e)=>(e.label))
}

const itemsMenu: TitleMenu[] = [
    {
        title: 'Menu',
        items: [
            {
                label: 'Dashboard',
                to: '#',
                icon: DashboardIcon,
                children: [
                    {
                        label: 'Analytics',
                        to: 'dashboard',
                    }
                ]
            },
            {
                label: 'Calendar',
                to: 'calendar',
                icon: CalendarIcon
            },

            {
                label: 'Profile',
                to: 'profile',
                icon: ProfileIcon
            },
            {
                label: 'Forms',
                to: '#',
                icon: FormIcon,
                children: [
                    {
                        label: 'Form Elements',
                        // to: 'form-layout.html',
                        to: 'formElements',
                    },
                    {
                        label: 'Form Layout',
                        to: 'formLayout',
                        // to: 'dashboard',
                    }
                ]
            },
            {
                label: 'Tables',
                to: 'tables',
                icon: TableIcon
            },
            {
                label: 'Settings',
                to: 'settings',
                icon: SettingIcon
            },
            {
                label: t('menu.settings'),
                to: '#',
                icon: SettingIcon,
                children: [
                    {
                        label: t('menu.regions'),
                        to: 'admin.config.regions',
                    },
                ]
            },
            {
                label: t('menu.security'),
                to: '#',
                icon: SecurityIcon,
                children: [
                    {
                        label: t('menu.roles'),
                        to: 'admin.security.roles',
                    },
                    {
                        label: t('menu.permissions'),
                        to: 'admin.security.permissions',
                    },
                    {
                        label: t('menu.users'),
                        to: 'admin.security.users',
                    },
                ]
            },
        ]
    },
    {
        title: 'Others',
        items: [
            {
                label: 'Chart',
                to: 'charts',
                icon: ChartIcon
            },
            {
                label: 'UI Elements',
                to: '#',
                icon: Gridcolspan,
                children: [
                    {
                        label: 'Alerts',
                        to: 'alerts',
                    },
                    {
                        label: 'Buttons',
                        to: 'buttons',
                    }
                ]
            },
            {
                label: 'Authentication',
                to: '#',
                icon: AuthIcon,
                children: [
                    {
                        label: 'Sign In',
                        to: 'login',
                    },
                    {
                        label: 'Sign Up',
                        to: 'register',
                    }
                ]
            },
        ]
    }
]
interface ItemMenu {
    label:string
    to: string
    icon?: DefineComponent<{}, {}, any>
    children?: ItemMenu[]
    title?: string
}

interface TitleMenu{
    title?: string
    items: ItemMenu[]
}

</script>

<style scoped>

</style>
