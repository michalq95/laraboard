<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3x1 font-bold">Offers</h1>
        <router-link
          :to="{ name: 'OfferCreateNew' }"
          class="py-3 px-2 bg-yellow-300 rounded-lg hover:bg-yellow-400"
          >Add new offer</router-link
        >
      </div>
    </template>
    <div v-if="offers.loading" class="flex justify-center">Loading...</div>
    <div v-else>
      <div>
        <label for="title" class="block text-sm font-medium text-gray-700"
          >Location</label
        >
        <button
          autocomplete="company_location"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
          @click.prevent="showMap = !showMap"
        >
          Show Map
        </button>
        <Map :list="offers.data"></Map>
      </div>
      <div class="grid grid-cols-1 gap-4">
        <div
          v-for="offer in offers.data"
          :key="offer.id"
          class="flex justify-between items-center py-3 px-5 shadow-md bg-blue-300 hover:bg-blue-300 h-[80px]"
        >
          <img :src="offer.image" alt="" class="w-8 object-cover" />
          <h4>
            <router-link
              :to="{ name: 'OfferView', params: { id: offer.id } }"
              >{{ offer.title }}</router-link
            >
          </h4>
          <h5>{{ offer.bracket_low }}-{{ offer.bracket_high }}</h5>
          <div
            v-if="offer.company_id === userCompanyId"
            class="flex flex-col justify-between items-center"
          >
            <router-link
              :to="{ name: 'OfferCreate', params: { id: offer.id } }"
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
          <div v-else></div>
        </div>
      </div>

      <div class="flex justify-center mt-5">
        <nav class="relative z-0 inline-flex justify-center-rounded-md">
          <a
            v-html="link.label"
            v-for="(link, i) of offers.links"
            :key="i"
            :disabled="!link.url"
            @click="getForPage(link)"
            class="relative inline-flex items-center px-4 py-2 border text-sm cursor-pointer flex-nowrap"
            :class="[
              link.active
                ? 'z-10 bg-blue-300 border-blue-400 text-blue-600'
                : 'border-gray-600 text-gray-500 ',
            ]"
          >
          </a>
        </nav>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import Map from "../components/Map.vue";

import store from "../store";
import { computed, ref } from "vue";
const offers = computed(() => store.state.offers);
const userCompanyId = computed(() => store.state.user?.data?.company?.id);
let showMap = ref(false);

store.dispatch("getOffers");

function deleteOffer(offer) {}

function getForPage(link) {
  if (!link.url || link.active) {
    return;
  }
  store.dispatch("getOffers", { url: link.url });
}
</script>

<style scoped lang="scss"></style>
