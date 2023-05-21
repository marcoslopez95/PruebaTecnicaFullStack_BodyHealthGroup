<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ $t('commons.create.view', { name: $t('views.roles.title') }) }}</h1>
        </div>
        <div>
            <ButtonComponent class="uppercase" @click="emit('index')">{{ $t('commons.button.back') }}</ButtonComponent>
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
                        <TextInput />

                    </div>

                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.roles.guard_name') }}
                        </label>
                        <TextInput />

                    </div>
                </div>



                <div class="mb-4.5">
                    <label class="mb-2.5 block text-black dark:text-white">
                        {{ $t('views.permissions.title', 2) }}
                    </label>
                </div>
                <MultiSelect></MultiSelect>

                <button class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import ButtonComponent from '@/Components/ButtonComponent.vue';
import MultiSelect from '@/Components/MultiSelect.vue';
import TextInput from '@/Components/TextInput.vue'
import { ref } from 'vue'
const emit = defineEmits(['index'])


</script>
