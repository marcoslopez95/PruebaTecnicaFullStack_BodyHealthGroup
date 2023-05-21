<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ $t('views.publications.title', 2) }}</h1>
        </div>
        <div>
            <ButtonComponent @click="clickInCreateOrEdit()" class="uppercase">{{ $t('commons.button.create') }}
            </ButtonComponent>
        </div>
    </div>

    <TableComponent :headers="headers" :items="helper.items" with-buttons @edit="clickInCreateOrEdit">
        <template #cel-labels="{ data }">
            <div class="flex flex-wrap items-center gap-3"  v-if="data.labels">
                <ChipComponent
                    variant="primary"
                    v-for="(chip, index) in data.labels"
                    :key="index">
                    {{ chip }}
                </ChipComponent>
            </div>
        </template>
        <template #cel-external_references="{ data }">
            <a
            target="_blank"
            v-for="(chip, index) in data.external_references"
                    :key="index"
                    :href="chip.url"
            >

            <ChipComponent

                    variant="primary"
                >
                    {{ chip.name }}
                </ChipComponent>
            </a>
        </template>
    </TableComponent>
</template>
<script setup lang="ts">
import ButtonComponent from '@/Components/ButtonComponent.vue';
import ChipComponent from '@/Components/ChipComponent.vue';
import TableComponent from '@/Components/TableComponent.vue';
import { helperStore } from '@/helper';
import { PublicationStore } from '@/stores/PublicationStore';
import { storeToRefs } from 'pinia';
import { Publication } from 'resources/ts/interfaces/Publication/Publication.model';
import { Head } from 'resources/ts/interfaces/TableInterface';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()
const helper = helperStore()
const publicationStore = PublicationStore()
const { form } = storeToRefs(publicationStore)
const emit = defineEmits(['create'])

const { url } = storeToRefs(helper)
const headers: Head[] = [
    {
        name: t('commons.id'),
        value: 'id'
    },
    {
        name: t('views.publications.labels'),
        value: 'labels'
    },
    {
        name: t('commons.created_at'),
        value: 'created_at'
    },
    {
        name: t('views.publication-categories.title'),
        value: 'publication_category.name'
    },
    {
        name: t('views.regions.title'),
        value: 'region.name'
    },
    {
        name: t('views.external-references.title'),
        value: 'external_references'
    },

    {
        name: t('commons.status'),
        value: 'isDeleted',
        status: 'deleted'
    },

]
//@ts-ignore
url.value = route('api.v1.publications.index')

helper.index()

const clickInCreateOrEdit = (item: Publication | null = null) => {
    if (item) {
        form.value = {
            content: item.content,
            external_references: item.external_references.map((el) => el.id),
            id: item.id,
            labels: item.labels,
            publication_category_id: item.publication_category.id,
            region_id: item.region?.id ?? ''
        }
    }
    else { publicationStore.resetForm() }
    emit('create')
}

</script>
