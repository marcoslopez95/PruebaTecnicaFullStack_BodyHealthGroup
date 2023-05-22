<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { PublicationStore } from '@/stores/PublicationStore';
import { ExternalReference } from 'resources/ts/interfaces/ExternalReference/ExternalReference.model';
const publicationStore = PublicationStore()

publicationStore.getPublications()

const getAllReferences= (external_references: ExternalReference[]) => {
    return external_references.map((external_ref: ExternalReference, index):string => {
        if(index === external_references.length -1 ){
            return `and <a class="hover:text-primary" href="${external_ref.url}">${external_ref.name}</a>`
        }
        return `<a class="hover:text-primary" href="${external_ref.url}">${external_ref.name}</a>,`
    }).join(' ')
}
</script>

<template>
    <AppLayout title="Dashboard">

        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
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
                                <h4 class=" font-bold text-black dark:text-white" v-if="publication.external_references.length > 0">
                                   {{ $t('views.dashboard.read-more') }} <span  v-html="getAllReferences(publication.external_references)"></span>
                                </h4>

                            </div>

                        </div>
                    </div>
                    <!-- End Footer -->
                </div>

            </div>

        </div>
    </AppLayout>
</template>
