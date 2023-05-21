<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ $t('views.publications.title', 2) }}</h1>
        </div>
        <div>
            <ButtonComponent @click="clickInCreateOrEdit" class="uppercase">{{ $t('commons.button.create') }}</ButtonComponent>
        </div>
    </div>

    <TableComponent :headers="headers" :items="helper.items" with-buttons @edit="clickInCreateOrEdit">
    </TableComponent>
</template>
<script setup lang="ts">
import ButtonComponent from '@/Components/ButtonComponent.vue';
import TableComponent from '@/Components/TableComponent.vue';
import { helperStore } from '@/helper';
import { PublicationCategoriesStore } from '@/stores/PublicationCategoriesStore';
import { storeToRefs } from 'pinia';
import { PublicationCategoryUpdate } from 'resources/ts/interfaces/PublicationCategory/PublicationCategory.dto';
import { Head } from 'resources/ts/interfaces/TableInterface';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()
const helper = helperStore()
const publicationCategoriesStore = PublicationCategoriesStore()
const { form } = storeToRefs(publicationCategoriesStore)
const emit = defineEmits(['create'])

const { url } = storeToRefs(helper)
const headers: Head[] = [
    {
        name: t('commons.id'),
        value: 'id'
    },
    {
        name: t('commons.name'),
        value: 'name'
    },
    {
        name: t('views.external-references.url'),
        value: 'url'
    },
    {
        name: t('commons.status'),
        value: 'isDeleted',
        status: 'deleted'
    },

]
//@ts-ignore
url.value = route('api.v1.external-references.index')

helper.index()

const clickInCreateOrEdit = (item: PublicationCategoryUpdate | null) => {
    if (item) { form.value = item }
    else { publicationCategoriesStore.resetForm() }
    emit('create')
}

</script>
