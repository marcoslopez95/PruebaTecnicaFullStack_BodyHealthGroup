<template>
    <div class="relative">
        <div class="flex items-center justify-between w-full py-3 pl-3 pr-10 text-sm bg-white border rounded-md cursor-pointer   "
            :class="isOpen ? 'border-primary' : 'border-stroke'" @click="isOpen = !isOpen">
            <span class="flex-grow truncate" v-if="selectedOptions.length > 0">
                {{ nameSelectes }}
            </span>
            <span class="flex-grow truncate text-gray-500" v-else>
                {{ $t('components.multiselect.select-options') }}
            </span>
            <svg class="w-5 h-5 ml-2 -mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>

        <div v-if="isOpen"
            class="absolute z-10 w-full py-2 mt-2 overflow-auto text-base bg-white border border-gray-300 rounded-md shadow-md max-h-48 ring-1 ring-black ring-opacity-5">
            <div v-if="options.length > 0" v-for="option in options" :key="option">
                <label class="flex items-center py-2 pl-3 pr-9">
                    <input type="checkbox" class="mr-3 form-checkbox h-5 w-5 text-blue-500" :value="option[valueOp]"
                        v-model="selectedOptions">
                    <span class="truncate">{{ option[nameOp] }}</span>
                </label>
            </div>
            <div v-else>
                    <span class="mx-3"> No data </span>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, watch, computed,toRefs } from 'vue'
const isOpen = ref(false);
// const selectedOptions = ref([]);
const emit = defineEmits(['update:modelValue'])

const props = defineProps<{
    options: any[]
    nameOp: string
    valueOp: string
    modelValue: []
}>()

const {modelValue:selectedOptions } = toRefs(props)
watch(selectedOptions, () =>{
    emit('update:modelValue', selectedOptions.value)
})

const nameSelectes = computed(() => {
    return selectedOptions.value
        .map((select:number) => props.options.find(item => select === item[props.valueOp])[props.nameOp]).join(', ')
})
</script>
