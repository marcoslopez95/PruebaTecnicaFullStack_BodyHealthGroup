<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ $t('views.publication-categories.title', 2) }}</h1>
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
import { RegionStore } from '@/stores/RegionStore';
import { storeToRefs } from 'pinia';
import { RegionUpdate } from 'resources/ts/interfaces/Region/Region.dto';
import { Head } from 'resources/ts/interfaces/TableInterface';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()
const helper = helperStore()
const regionStore = RegionStore()
const { form } = storeToRefs(regionStore)
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
        name: t('commons.status'),
        value: 'isDeleted',
        status: 'deleted'
    },

]
//@ts-ignore
url.value = route('api.v1.regions.index')

helper.index()

const clickInCreateOrEdit = (item: RegionUpdate | null) => {
    if (item) { form.value = item }
    else { regionStore.resetForm() }
    emit('create')
}

</script>
