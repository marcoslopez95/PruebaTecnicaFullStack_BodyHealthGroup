import { helperStore } from '@/helper'
import { defineStore, storeToRefs } from 'pinia'
import { RegionStore } from './RegionStore'
import { ExternalReferenceStore } from './ExternalReferenceStore'
import { PublicationCategoriesStore } from './PublicationCategoriesStore'
import { ref } from 'vue'
import { Publication } from 'resources/ts/interfaces/Publication/Publication.model'
import {
  PublicationCreate,
  PublicationUpdate,
} from 'resources/ts/interfaces/Publication/Publication.dto'

export const PublicationStore = defineStore('Publication', () => {
  const helper = helperStore()
  const region = RegionStore()
  const external_reference = ExternalReferenceStore()
  const publication_category = PublicationCategoriesStore()

  const { regions } = storeToRefs(region)
  const { getRegions } = region
  const { externalReferences } = storeToRefs(external_reference)
  const { getExternalReferences } = external_reference
  const { publicationCategories } = storeToRefs(publication_category)
  const { getPublicationCategories } = publication_category

  const publications = ref<Publication[]>([])
  const getPublications = () => {
    helper.http('/api/v1/admin/config/publications').then((res: any) => {
      publications.value = res.data.data as Publication[]
    })
  }

  const form = ref<PublicationCreate | PublicationUpdate>({
    labels: [],
    content: '',
    external_references: [],
    publication_category_id: '',
    region_id: '',
  })

  const resetForm = () => {
    form.value = {
      labels: [],
      content: '',
      external_references: [],
      publication_category_id: '',
      region_id: '',
    }
  }
  return {
    regions,
    getRegions,
    externalReferences,
    getExternalReferences,
    publicationCategories,
    getPublicationCategories,
    resetForm,
    form,
    publications,
    getPublications,
  }
})
