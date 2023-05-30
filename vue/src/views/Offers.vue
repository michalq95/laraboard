<template>
    <PageComponent>
        <template v-slot:header>
            <div class="flex justify-between items-center">
                <h1 class="text-3x1 font-bold">Offers</h1>
                <router-link
                    :to="{ name: 'OfferCreate' }"
                    class="py-3 px-2 bg-yellow-300 rounded-lg hover:bg-yellow-400"
                    >Add new offer</router-link
                >
            </div>
        </template>
        <div class="grid grid-cols-1 gap-4">
            <div
                v-for="offer in offers"
                :key="offer.id"
                class="flex justify-between items-center py-3 px-5 shadow-md bg-blue-300 hover:bg-blue-300 h-[80px]"
            >
                <img :src="offer.image" alt="" class="w-8 object-cover" />
                <h4>{{ offer.title }}</h4>
                <h5>{{ offer.bracket_low }}-{{ offer.bracket_high }}</h5>
                <div class="flex flex-col justify-between items-center">
                    <router-link
                        :to="{ name: 'OfferView', params: { id: offer.id } }"
                        class="py-2 px-2 bg-blue-500 rounded-lg hover:bg-blue-400"
                        >Edit offer</router-link
                    >
                    <button
                        v-if="offer.id"
                        type="button"
                        @click="deleteOffer(offer)"
                        class="h-8 w-8 items-center text-red-700 bg-red-300"
                    >
                        X
                    </button>
                </div>
            </div>
        </div>
    </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import store from "../store";
import { computed } from "vue";
const offers = computed(() => store.state.offers);

function deleteOffer(offer) {}
</script>

<style scoped lang="scss"></style>
