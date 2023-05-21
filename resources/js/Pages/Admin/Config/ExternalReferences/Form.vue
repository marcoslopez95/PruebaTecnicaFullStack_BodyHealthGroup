<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ getTitle() }}</h1>
        </div>
        <div>
            <ButtonComponent class="uppercase" @click="emit('index')">{{ $t('commons.button.back') }}</ButtonComponent>
        </div>
        <div>
            <ButtonComponent class="uppercase" @click="clickInSaveOrUpdate" isAsync>{{ getButton() }}</ButtonComponent>
        </div>
    </div>
    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <form action="#">
            <div class="p-6.5">
                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('commons.name') }} <span class="text-meta-1">*</span>
                        </label>
                        <TextInput v-model="externalReferenceStore.form.name" />

                    </div>

                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.external-references.url') }} <span class="text-meta-1">*</span>
                        </label>
                        <TextInput v-model="externalReferenceStore.form.url" />
                    </div>
                </div>

            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import ButtonComponent from '@/Components/ButtonComponent.vue';
import TextInput from '@/Components/TextInput.vue'
import { helperStore } from '@/helper';
import { ExternalReferenceStore } from '@/stores/ExternalReferenceStore';
import { useI18n } from 'vue-i18n';
const { t } = useI18n()
const helper = helperStore()
const emit = defineEmits(['index'])
const externalReferenceStore = ExternalReferenceStore()

const getTitle = (): string => {
    if ('id' in externalReferenceStore.form) {
        return t('commons.update.view', { name: t('views.external-references.title') })
    }
    return t('commons.create.view', { name: t('views.external-references.title') })
}

const getButton = (): string => {
    if ('id' in externalReferenceStore.form) {
        return t('commons.button.update')
    }
    return t('commons.button.save')
}

const clickInSaveOrUpdate = async () => {
    try {
        if ('id' in externalReferenceStore.form) {
            const { id, ...data } = externalReferenceStore.form
            await helper.put(id, data)
        } else {
            await helper.create(externalReferenceStore.form)
        }
        emit('index')
    } catch (e) {

    }

}
</script>
