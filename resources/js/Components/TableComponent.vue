<template>
    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-center bg-gray-2 text-left dark:bg-meta-4">
                        <slot v-for="head, i in headers" :name="setNameHead(head.value)">
                            <th class="min-w-[220px] py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                                {{ head.name }}
                            </th>
                        </slot>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="items.length > 0" v-for="item, i in items" :key="i">
                        <td v-for="(head, j) in headers" :key="j"
                            class="text-center border-b border-[#eee] py-5 px-4 pl-9 dark:border-strokedark xl:pl-11">
                            <slot :name="`cel-${head.value}`" :data="item">
                                <ChipComponent v-if="head.status === true || head.status === 'deleted'"
                                    :variant="getStatusColor(item, head)">
                                    {{ getStatus(item, head) }}
                                </ChipComponent>
                                <span v-else class="text-center">{{ getValue(item, head) }}</span>
                                <div v-if="withButtons && head.value == 'actions'" class="space-x-3.5">
                                    <button class="hover:text-primary" @click="emit('edit',item)">
                                        <EditIcon></EditIcon>
                                    </button>
                                    <button type="button" class="hover:text-primary" @click="openConfirmModal(item)">
                                        <TrashedIcon></TrashedIcon>
                                    </button>
                                </div>
                            </slot>
                        </td>
                    </tr>
                    <tr v-else>
                        <td :colspan="headers.length" class="text-center py-5">
                            {{ $t('commons.no-data') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <PaginationComponent :total-pages="totalPages" :total="total" :per-page="perPage" :current-page="currentPage"
      :has-more-pages="hasMorePages" @pagechanged="showMore"></PaginationComponent> -->
    </div>
    <DialogModal :show="confirmModal" @close="confirmModal = false">
        <template #title>
            {{ title }}
        </template>
        <template #content>
            <span>{{ content }}</span>
        </template>
        <template #footer>
            <div class="flex w-full justify-between">
                <div>
                    <ButtonComponent @click="confirmModal=false">
                        {{ $t('commons.close') }}
                    </ButtonComponent>
                </div>
                <div>
                    <ButtonComponent variant="danger">
                        {{ $t('commons.confirm') }}
                    </ButtonComponent>
                </div>
            </div>
        </template>
    </DialogModal>
</template>

<script setup lang="ts">
import { Head, Variant } from '@/../ts/interfaces/TableInterface'
import DialogModal from '@/Components/DialogModal.vue'
import { toRefs, ref } from 'vue'
import { useI18n } from 'vue-i18n'
import ChipComponent from './ChipComponent.vue'
import EditIcon from '@/svg-components/EditIcon.vue'
import TrashedIcon from '@/svg-components/TrashedIcon.vue'
import ButtonComponent from './ButtonComponent.vue'
import { helperStore } from '@/helper'
import { storeToRefs } from 'pinia'
const { t } = useI18n()
const emit = defineEmits(['edit', 'delete'])
const props = defineProps<TableComponentInterface>()
const { headers } = toRefs(props)

const helper = helperStore()
const { item: itemH } = storeToRefs(helper)

const setNameHead = (head: string) => head.toLocaleLowerCase().replace(' ', '-')

const getValue = (item: any, head: Head) => {
    const value = head.value
    let valueArray = value.split('.')
    let res = item;

    valueArray.forEach((pos: string) => {
        res = res[pos] ?? ''
    })

    return res
}

if (!headers.value.find(item => item.value === 'actions') && props.withButtons) {
    headers.value.push({
        name: t('commons.Actions'),
        value: 'actions'
    })
}

const confirmModal = ref(false)
const title = ref('')
const content = ref('')
const openConfirmModal = (item: any) => {
    itemH.value = item
    confirmModal.value = true
    const deleted = item.isDeleted ?? false
    title.value = deleted ? t('commons.restore.title') : t('commons.confirm-delete-title')
    content.value = deleted ? t('commons.restore.content') : t('commons.confirm-delete')
}
const okDeletedRestore = () => {
  emit('delete', itemH.value)
  helper
    .deleted(itemH.value.id)
    .then(() => {
      helper.index()
      confirmModal.value = false
    })
}

const getStatusColor = (item: any, head: Head): Variant => {
    return getValue(item, head) ? 'success' : 'danger'
}
const getStatus = (item: any, head: Head): string => {
    return getValue(item, head) ?
        t('commons.active') :
        t('commons.inactive')
}
// ----------------------------------
interface TableComponentInterface {
    headers: Head[]
    items: any[]
    withButtons?: boolean
    editIcon?: boolean
    deleteIcon?: boolean
}
// ----------------------------------
</script>

<style scoped></style>
