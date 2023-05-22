<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { PublicationStore } from '@/stores/PublicationStore';
import { ExternalReference } from 'resources/ts/interfaces/ExternalReference/ExternalReference.model';
import LoadingIcon from '@/svg-components/LoadingIcon.vue';
import { storeToRefs } from 'pinia';
const publicationStore = PublicationStore()

publicationStore.getPublications()
const {isEnd} = storeToRefs(publicationStore)
const getAllReferences = (external_references: ExternalReference[]) => {
    return external_references.map((external_ref: ExternalReference, index): string => {
        if (index === external_references.length - 1) {
            return `and <a class="hover:text-primary" href="${external_ref.url}">${external_ref.name}</a>`
        }
        return `<a class="hover:text-primary" href="${external_ref.url}">${external_ref.name}</a>,`
    }).join(' ')
}
const scrollContainer = ref(null);
const handleScroll = (event: any) => {
    const element = event.target;
    if (element.scrollHeight - element.scrollTop === element.clientHeight) {
        isEnd.value = true
    }
}

onMounted(() => {
    //@ts-ignore
    scrollContainer.value.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    //@ts-ignore
    scrollContainer.value.removeEventListener("scroll", handleScroll);
});

watch(isEnd, (valor: boolean) => {
    if(valor){
        publicationStore.getPublications(true)
    }
})
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="mx-auto max-w-screen-2xl h-[500px] p-4 md:p-6 2xl:p-10 overflow-y-auto" ref="scrollContainer">
            <div class="grid grid-cols-1 gap-4 2xl:gap-7.5">
                <!-- Card Item Start -->
                <div v-for="publication, i in publicationStore.publications" :key="i"
                    class="rounded-sm border border-stroke bg-white py-3 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <!-- Start Title -->
                    <div class="border-b border-[#507799] border-opacity-20 px-7.5 ">

                        <div class="mt-1 flex items-end justify-between">
                            <div>
                                <h4 class="text-title-sm font-bold text-black dark:text-white">
                                    {{ publication.publication_category.name }}
                                </h4>

                            </div>
                            <div>
                                <h4 class="text-title-sm font-bold text-black dark:text-white">
                                    {{ publication.region?.name ?? '' }}
                                </h4>

                            </div>

                        </div>
                    </div>
                    <!-- End Title -->
                    <!-- Start Body -->
                    <div class="border-b border-[#507799] border-opacity-20 px-7.5 ">

                        <div class="mt-1 flex items-end justify-between">
                            <p>
                                {{ publication.content }}
                            </p>
                        </div>
                    </div>
                    <!-- End Body-->
                    <!-- Start Footer -->
                    <div class=" py-2 px-7.5 ">

                        <div class="mt-1 flex items-end justify-between">
                            <div>
                                <h4 class="text-title-sm font-bold text-black dark:text-white">
                                    {{ publication.created_at }}
                                </h4>

                            </div>
                            <div>
                                <h4 class=" font-bold text-black dark:text-white"
                                    v-if="publication.external_references.length > 0">
                                    {{ $t('views.dashboard.read-more') }} <span
                                        v-html="getAllReferences(publication.external_references)"></span>
                                </h4>

                            </div>

                        </div>
                    </div>
                    <!-- End Footer -->
                </div>

            </div>

            <span v-if="isEnd" class="flex">
                <LoadingIcon class='fill-boxdark animate-spin h-10 w-10 mx-auto' width="30" height="30" />
            </span>
        </div>
    </AppLayout>
</template>
