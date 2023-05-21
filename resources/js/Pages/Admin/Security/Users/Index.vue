<template>
    <AppLayout :title="$t('views.users.title')">
        <List v-if="!create" @create="create = true" />
        <Form v-else @index="create = false" />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import List from './List.vue'
import Form from './Form.vue'
import { ref } from 'vue'
import { UserStore } from '@/stores/UserStore';
const create = ref(false)
const userStore = UserStore()

userStore.getRoles()
</script>

<style scoped></style>
