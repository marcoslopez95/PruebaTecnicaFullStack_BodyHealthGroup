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
                    <div class="w-full xl:w-1/3">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.regions.title') }}
                        </label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                            <select
                                class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                v-model="publicationStore.form.region_id">
                                <option value="">{{ $t('components.select-only') }}</option>
                                <option v-for="region, i in publicationStore.regions" :key="i" :value="region.id">{{
                                    region.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full xl:w-1/3">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.publication-categories.title') }} <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                            <select
                                class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                v-model="publicationStore.form.publication_category_id">
                                <option value="">{{ $t('components.select-only') }}</option>
                                <option v-for="item, i in publicationStore.publicationCategories" :key="i" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>

                    </div>
                    <div class="w-full xl:w-1/3">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.external-references.title') }}
                        </label>
                        <MultiSelect :options="publicationStore.externalReferences" name-op="name" value-op="id"
                            v-model="publicationStore.form.external_references"></MultiSelect>

                    </div>


                </div>
                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.publications.labels') }}
                            <small class="ml-3 text-">{{ $t('views.publications.label-instructions') }}</small>
                        </label>
                        <div class="flex flex-wrap items-center gap-3">
                            <ChipComponent class="hover:cursor-pointer hover:bg-danger hover:text-white" variant="primary"
                                v-for="(chip, index) in publicationStore.form.labels" :key="index"
                                @click="removeChip(index)">
                                {{ chip }}
                            </ChipComponent>
                            <TextInput class="w-1/3" @keyup.enter="addChip" v-model="newChip"
                                :placeholder="$t('views.publications.agg-label')" />


                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="mb-2.5 block text-black dark:text-white">
                        {{ $t('views.publications.content') }}  <span class="text-meta-1">*</span>
                    </label>
                    <textarea v-model="publicationStore.form.content" rows="6" :placeholder="$t('views.publications.content-type')"
                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"></textarea>
                        <small :class="publicationStore.form.content.length > 255 ? 'text-danger font-bold' : ''">{{ publicationStore.form.content.length }} / 255</small>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import ButtonComponent from '@/Components/ButtonComponent.vue';
import MultiSelect from '@/Components/MultiSelect.vue';
import TextInput from '@/Components/TextInput.vue'
import { helperStore } from '@/helper';
import { PublicationStore } from '@/stores/PublicationStore';
import { useI18n } from 'vue-i18n';
import ChipComponent from '@/Components/ChipComponent.vue';
const { t } = useI18n()
const helper = helperStore()
const emit = defineEmits(['index'])
const publicationStore = PublicationStore()

const getTitle = (): string => {
    if ('id' in publicationStore.form) {
        return t('commons.update.view', { name: t('views.publications.title') })
    }
    return t('commons.create.view', { name: t('views.publications.title') })
}

const getButton = (): string => {
    if ('id' in publicationStore.form) {
        return t('commons.button.update')
    }
    return t('commons.button.save')
}

const clickInSaveOrUpdate = async () => {
    try {
        if ('id' in publicationStore.form) {
            const { id, ...data } = publicationStore.form
            await helper.put(id, data)
        } else {
            await helper.create(publicationStore.form)
        }
        emit('index')
    } catch (e) {

    }

}

const newChip = ref('');

const addChip = () => {
    if (newChip.value.trim() !== '') {
        publicationStore.form.labels.push(newChip.value.trim());
        newChip.value = '';
    }
};

const removeChip = (index: number) => {
    publicationStore.form.labels.splice(index, 1);
};
</script>
