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
                        <TextInput
                        v-model="roleStore.form.name"
                        />

                    </div>

                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.roles.guard_name') }}
                        </label>
                        <TextInput
                            v-model="roleStore.form.guard_name"
                        />

                    </div>
                </div>



                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        {{ $t('views.permissions.title', 2) }}
                    </label>
                </div>
                <MultiSelect
                    :options="roleStore.permissions"
                    name-op="name"
                    value-op="id"
                    v-model="roleStore.form.permissions"
                    ></MultiSelect>

                <!-- <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                    {{ $t('commons.create')}}
                </button> -->
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import ButtonComponent from '@/Components/ButtonComponent.vue';
import MultiSelect from '@/Components/MultiSelect.vue';
import TextInput from '@/Components/TextInput.vue'
import { helperStore } from '@/helper';
import { RoleStore } from '@/stores/RoleStore';
import { useI18n } from 'vue-i18n';
const { t } = useI18n()
const helper = helperStore()
const emit = defineEmits(['index'])
const roleStore = RoleStore()

const getTitle = () :string => {
    if('id' in roleStore.form){
        return t('commons.update.view', { name: t('views.roles.title') })
    }
    return t('commons.create.view', { name: t('views.roles.title') })
}

const getButton = () :string => {
    if('id' in roleStore.form){
        return t('commons.button.update')
    }
    return t('commons.button.save')
}

const clickInSaveOrUpdate = async () => {
    try{
        if('id' in roleStore.form){
            const {id,...data} = roleStore.form
            await helper.put(id,data)
        }else {
            await helper.create(roleStore.form)
        }
        emit('index')
    }catch(e){

    }

}
</script>
