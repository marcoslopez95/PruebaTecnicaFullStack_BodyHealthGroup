<template>
    <AppLayout :title="$t('views.roles.title')">
        <List v-if="!create" @create="create = true" />
        <Form v-else @index="create = false" />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import List from './List.vue'
import Form from './Form.vue'
import { ref } from 'vue'
import { RoleStore } from '@/stores/RoleStore';
const create = ref(false)
const roleStore = RoleStore()

roleStore.getPermissions()
</script>

<style scoped></style>
