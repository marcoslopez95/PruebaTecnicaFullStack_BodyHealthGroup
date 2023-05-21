<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ $t('commons.create.view', { name: $t('views.roles.title') }) }}</h1>
        </div>
        <div>
            <ButtonComponent class="uppercase" @click="emit('index')">{{ $t('commons.button.back') }}</ButtonComponent>
        </div>
        <div>
            <ButtonComponent class="uppercase" @click="emit('index')">{{ $t('commons.button.save') }}</ButtonComponent>
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
import { RoleStore } from '@/stores/RoleStore';
import { RoleCreate } from 'resources/ts/interfaces/Role/Role.dto';
import { ref } from 'vue'
const emit = defineEmits(['index'])
const roleStore = RoleStore()

</script>
