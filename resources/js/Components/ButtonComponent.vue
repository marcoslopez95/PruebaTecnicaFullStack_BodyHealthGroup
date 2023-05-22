<script setup lang="ts">
import { helperStore } from '@/helper';
import { Variant } from 'resources/ts/interfaces/TableInterface';

const helper = helperStore()
const props = defineProps<ButtonInterface>();

const typeVariant = {
    danger: 'bg-danger',
    success: 'bg-success',
    warning: 'bg-warning',
    primary: 'bg-primary',
    secondary: 'bg-secondary',
}
const changeButtonForAsync = ():string => {
    if(props.isAsync){
        return helper.loading ? 'bg-opacity-80' :'cursor-pointer hover bg-opacity-90'
    }
    return ''
}
// ---------------------------------------
type TypeButton = 'submit' | 'button' | 'reset';
interface ButtonInterface {
    type?: TypeButton
    variant?: Variant,
    isAsync?: boolean
}
</script>

<template>
    <button :type="type ?? 'button'"
        class="inline-flex items-center justify-center rounded-md py-2 px-5 text-center font-medium text-white hover:bg-opacity-90 lg:px-4 xl:px-5"
        :class="[
            changeButtonForAsync(),
            typeVariant[variant ?? 'primary']
            ]"
        :disabled="helper.loading && isAsync">
        <span v-if="helper.loading && isAsync" class="flex">
            <LoadinIcon class='fill-white animate-spin h-5 w-5 mx-auto' width="30" height="30" />
        </span>
        <slot>Button</slot>
    </button>
</template>
