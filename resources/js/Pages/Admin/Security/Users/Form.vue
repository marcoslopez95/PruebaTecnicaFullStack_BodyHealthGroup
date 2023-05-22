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
                    <div class="mb-4.5 w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.roles.title') }} <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative z-20 bg-transparent dark:bg-form-input">
                            <select
                                class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                                v-model="userStore.form.role_id">
                                <option value="">{{ $t('components.select-only') }}</option>
                                <option v-for="role, i in userStore.roles" :key="i" :value="role.id">{{ role.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('commons.name') }} <span class="text-meta-1">*</span>
                        </label>
                        <TextInput v-model="userStore.form.name" />

                    </div>

                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('commons.email') }} <span class="text-meta-1">*</span>
                        </label>
                        <TextInput v-model="userStore.form.email" />
                    </div>

                </div>
                <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.users.password') }} <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <TextInput :type="showPassword ? 'text' : 'password'" v-model="userStore.form.password" />
                            <div class="absolute right-4 top-4 hover:cursor-pointer" @click="showPassword = !showPassword">
                                <EyeIcon v-if="showPassword" opacity="0.5" width="22" height="22" />
                                <EyeOffIcon v-else opacity="0.5" width="22" height="22" />
                            </div>
                        </div>

                    </div>

                    <div class="w-full xl:w-1/2">
                        <label class="mb-2.5 block text-black dark:text-white">
                            {{ $t('views.users.password_confirmation') }} <span class="text-meta-1">*</span>
                        </label>
                        <div class="relative">
                            <TextInput :type="showPasswordConfirmation ? 'text' : 'password'"
                                v-model="userStore.form.password_confirmation" />
                            <div class="absolute right-4 top-4 hover:cursor-pointer" @click="showPasswordConfirmation = !showPasswordConfirmation">
                                <EyeIcon v-if="showPasswordConfirmation" opacity="0.5" width="22" height="22" />
                                <EyeOffIcon v-else opacity="0.5" width="22" height="22" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import ButtonComponent from '@/Components/ButtonComponent.vue';
import TextInput from '@/Components/TextInput.vue'
import { helperStore } from '@/helper';
import { UserStore } from '@/stores/UserStore';
import { useI18n } from 'vue-i18n';
import EyeIcon from '@/svg-components/EyeIcon.vue';
import EyeOffIcon from '@/svg-components/EyeOffIcon.vue';
const { t } = useI18n()
const helper = helperStore()
const emit = defineEmits(['index'])
const userStore = UserStore()

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

const getTitle = (): string => {
    if ('id' in userStore.form) {
        return t('commons.update.view', { name: t('views.users.title') })
    }
    return t('commons.create.view', { name: t('views.users.title') })
}

const getButton = (): string => {
    if ('id' in userStore.form) {
        return t('commons.button.update')
    }
    return t('commons.button.save')
}

const clickInSaveOrUpdate = async () => {
    try {
        if ('id' in userStore.form) {
            const { id, ...data } = userStore.form
            await helper.put(id, data)
        } else {
            await helper.create(userStore.form)
        }
        emit('index')
    } catch (e) {

    }

}
</script>
