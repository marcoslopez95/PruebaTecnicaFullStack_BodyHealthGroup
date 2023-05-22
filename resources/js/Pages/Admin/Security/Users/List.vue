<template>
    <div class="flex justify-between text-right my-3 mr-5">
        <div class="mx-5 my-auto">
            <h1 class="font-extrabold text-2xl">{{ $t('views.users.title', 2) }}</h1>
        </div>
        <div>
            <ButtonComponent @click="clickInCreateOrEdit()" class="uppercase">{{ $t('commons.button.create') }}</ButtonComponent>
        </div>
    </div>

    <TableComponent :headers="headers" :items="helper.items" with-buttons @edit="clickInCreateOrEdit">
    </TableComponent>
</template>
<script setup lang="ts">
import ButtonComponent from '@/Components/ButtonComponent.vue';
import TableComponent from '@/Components/TableComponent.vue';
import { helperStore } from '@/helper';
import { UserStore } from '@/stores/UserStore';
import { storeToRefs } from 'pinia';
import { PermissionUpdate } from 'resources/ts/interfaces/Permission/Permission.dto';
import { Head } from 'resources/ts/interfaces/TableInterface';
import { UserUpdate } from 'resources/ts/interfaces/User/User.dto';
import { User } from 'resources/ts/interfaces/User/User.model';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()
const helper = helperStore()
const userStore = UserStore()
const { form } = storeToRefs(userStore)
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
        name: t('commons.email'),
        value: 'email'
    },
    {
        name: t('commons.created_at'),
        value: 'created_at'
    },
    {
        name: t('views.roles.title'),
        value: 'role.name'
    },
    {
        name: t('commons.status'),
        value: 'isDeleted',
        status: 'deleted'
    },

]
//@ts-ignore
url.value = route('api.v1.users.index')

helper.index()

const clickInCreateOrEdit = (item: User | null = null) => {
    console.log(item)
    if (item) {
        form.value = {
            email: item.email,
            id: item.id,
            name: item.name,
            role_id: item.role.id,
        }
    }
    else { userStore.resetForm() }
    emit('create')
}

</script>
