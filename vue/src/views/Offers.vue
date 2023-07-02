<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3x1 font-bold">Offers</h1>
        <router-link
          v-if="userCompanyId"
          :to="{ name: 'OfferCreateNew' }"
          class="py-3 px-2 rounded-lg bg-yellow-300 hover:bg-yellow-400 dark:bg-yellow-900 dark:hover:bg-yellow-800"
          >Add new offer</router-link
        >
      </div>
    </template>
    <div v-if="offers.loading" class="flex justify-center">Loading...</div>
    <div v-else>
      {{ offers.data[0] }}

      <div>
        <label for="search" class="block text-sm font-medium text-gray-500"
          >Search</label
        >
        <input
          type="text"
          name="search"
          id="search"
          v-model="queryString"
          autocomplete="query string"
          @keyup.enter="search"
          class="mt-1 py-3 w-5/6 dark:bg-slate-300 dark:text-black focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md"
        />
        <button
          autocomplete="search"
          class="mt-1 focus:ring-indigo-500 w-1/6 py-3 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-r-md"
          @click="search"
        >
          Search
        </button>
      </div>
      <div>
        <button
          autocomplete="company_location"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
          @click.prevent="showMap = !showMap"
        >
          Show Map
        </button>
        <Map v-if="showMap" :list="offers.data"></Map>
      </div>
      <div class="grid grid-cols-1 gap-4">
        <div v-for="offer in offers.data" :key="offer.id">
          <OfferPanel :offer="offer"></OfferPanel>
        </div>
      </div>

      <!-- <div class="flex justify-center mt-5">
        <nav class="relative z-0 inline-flex justify-center-rounded-md">
          <a
            v-html="link.label"
            v-for="(link, i) of offers.links"
            :key="i"
            :disabled="!link.url"
            @click="getForPage(link)"
            class="relative inline-flex items-center px-4 py-2 border text-sm cursor-pointer flex-nowrap"
          >
          </a>
        </nav>
      </div> -->
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
import Map from "../components/Map.vue";
import OfferPanel from "../components/OfferPanel.vue";

import store from "../store";
import { computed, ref } from "vue";
const offers = computed(() => store.state.offers);
const userCompanyId = computed(() => store.state.user?.data?.company?.id);
let showMap = ref(false);
let queryString = ref("");

store.dispatch("getOffers");

function deleteOffer(offer) {}
function search() {
  store.dispatch("getOffers", { keywords: queryString.value });
}
</script>

<style scoped lang="scss"></style>
