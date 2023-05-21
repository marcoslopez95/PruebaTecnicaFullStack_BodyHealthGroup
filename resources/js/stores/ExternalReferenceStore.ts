import { helperStore } from '@/helper'
import { defineStore } from 'pinia'
import { ExternalReferenceCreate, ExternalReferenceUpdate } from 'resources/ts/interfaces/ExternalReference/ExternalReference.dto'
import { ExternalReference } from 'resources/ts/interfaces/ExternalReference/ExternalReference.model'
import { PublicationCategoryCreate, PublicationCategoryUpdate } from 'resources/ts/interfaces/PublicationCategory/PublicationCategory.dto'
import { PublicationCategory } from 'resources/ts/interfaces/PublicationCategory/PublicationCategory.model'
import { ref } from 'vue'

export const ExternalReferenceStore = defineStore('External-References', () => {
  const helper = helperStore()

  const externalReferences = ref<ExternalReference[]>([])
  const getExternalReferences = () => {
    helper.http('/api/v1/admin/config/regions').then((res: any) => {
        externalReferences.value = res.data.data as ExternalReference[]
    })
  }

  const form = ref<ExternalReferenceCreate | ExternalReferenceUpdate>({
    name: '',
    url: ''
  })

  const resetForm = () => {
    form.value = {
        name: '',
        url: ''
    }
  }
  return {
    externalReferences,
    getExternalReferences,
    form,
    resetForm
  }
})
