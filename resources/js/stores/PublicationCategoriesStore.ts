import { helperStore } from '@/helper'
import { defineStore } from 'pinia'
import { PublicationCategoryCreate, PublicationCategoryUpdate } from 'resources/ts/interfaces/PublicationCategory/PublicationCategory.dto'
import { PublicationCategory } from 'resources/ts/interfaces/PublicationCategory/PublicationCategory.model'
import { ref } from 'vue'

export const PublicationCategoriesStore = defineStore('Publication-Categories', () => {
  const helper = helperStore()

  const publicationCategories = ref<PublicationCategory[]>([])
  const getPublicationCategories = () => {
    helper.http('/api/v1/admin/config/regions').then((res: any) => {
        publicationCategories.value = res.data.data as PublicationCategory[]
    })
  }

  const form = ref<PublicationCategoryCreate | PublicationCategoryUpdate>({
    name: '',
  })

  const resetForm = () => {
    form.value = {
      name: '',
    }
  }
  return {
    publicationCategories,
    getPublicationCategories,
    form,
    resetForm
  }
})
