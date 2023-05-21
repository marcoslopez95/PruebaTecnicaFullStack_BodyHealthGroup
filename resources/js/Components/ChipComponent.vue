<template>
    <p
        :class="type[variant ?? 'success']"
        class="inline-flex rounded-full bg-success bg-opacity-10 py-1 px-3 text-sm font-medium text-success">
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
}
interface ChipInterface {
    variant?: Variant
}


</script>

<style scoped></style>
