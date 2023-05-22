<template>
    <p
        :class="type[variant ?? 'success']"
        class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium ">
        <slot>Chip</slot>
    </p>
</template>

<script setup lang="ts">
import { Variant } from 'resources/ts/interfaces/TableInterface';


defineProps<ChipInterface>()
const type = {
    danger: 'bg-danger text-danger',
    success: 'bg-success text-success',
    warning: 'bg-warning text-warning',
    primary: 'bg-primary text-primary',
    secondary: 'bg-secondary text-secondary',
}
interface ChipInterface {
    variant?: Variant
}


</script>

<style scoped></style>
