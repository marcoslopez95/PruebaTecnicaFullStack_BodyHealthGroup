import { helperStore } from '@/helper'
import { defineStore } from 'pinia'
import { RegionCreate, RegionUpdate } from 'resources/ts/interfaces/Region/Region.dto'
import { Region } from 'resources/ts/interfaces/Region/Region.model'
import { ref } from 'vue'

export const RegionStore = defineStore('Region', () => {
  const helper = helperStore()

  const regions = ref<Region[]>([])
  const getRegions = () => {
    helper.http('/api/v1/admin/config/regions').then((res: any) => {
      regions.value = res.data.data as Region[]
    })
  }

  const form = ref<RegionCreate | RegionUpdate>({
    name: '',
  })

  const resetForm = () => {
    form.value = {
      name: '',
    }
  }
  return {
    regions,
    getRegions,
    form,
    resetForm
  }
})
