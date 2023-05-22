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
  const { pagination } = storeToRefs(helper)

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
  const getPublications = (pushed = false, search = '') => {
    if(pushed){
        pagination.value.currentPage ++
    }
    pagination.value.perPage = 5
    helper.http('/api/v1/publications','get',{
        params:{
            search,
            perPage: pagination.value.perPage,
            currentPage: pagination.value.currentPage,
            paginated: 1,
        }
    }).then((res: any) => {
        if(pushed) {
            publications.value.push(...res.data.data.data)
            isEnd.value = false
            return
        }
        publications.value = res.data.data.data as Publication[]
    })
  }
  const isEnd = ref(false)

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
    isEnd
  }
})
