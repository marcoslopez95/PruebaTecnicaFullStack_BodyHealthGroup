<template>
    <AppLayout :title="$t('views.publications.title')">
        <List v-if="!create" @create="create = true" />
        <Form v-else @index="create = false" />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import List from './List.vue'
import Form from './Form.vue'
import { ref } from 'vue'
import { PublicationStore } from '@/stores/PublicationStore';
const create = ref(false)

const publicationStore = PublicationStore()

publicationStore.getRegions()
publicationStore.getExternalReferences()
publicationStore.getPublicationCategories()
</script>

<style scoped></style>
