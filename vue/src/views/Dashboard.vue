<template>
  <PageComponent title="Dashboard">
    <template v-slot:header>
      <div class="flex justify-between items-center py-5">
        <h1 class="text-3x1 font-bold">Company</h1>

        <span v-if="!user.company">
          <router-link
            :to="{ name: 'CompanyCreate' }"
            class="py-3 px-2 bg-yellow-300 rounded-lg hover:bg-yellow-400"
            >Create new company</router-link
          >
        </span>
        <span v-else>
          {{ user.company.name }}
          <router-link
            :to="{ name: 'CompanyCreate' }"
            class="py-3 px-2 bg-yellow-300 rounded-lg hover:bg-yellow-400"
            >Edit your company</router-link
          >
        </span>
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
          <div class="flex flex-col justify-between items-center">
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
        </div>
      </div>
    </template>
  </PageComponent>
  <!-- <button @click="showMap = !showMap">Show Map</button> -->
  <!-- <Map v-if="showMap" @setPos="setPos"></Map> -->
</template>

<script setup>
import { ref, computed, watchEffect } from "vue";
import { useStore } from "vuex";
import PageComponent from "../components/PageComponent.vue";
const store = useStore();

const user = computed(() => store.state.user.data);
let offers = computed(() => store.state.userOffers);

// if (user.value && user.value.company) {
//   store.dispatch("getMyOffers", { id: user.value.company.id }).then((res) => {
//     offers = res.data;
//     console.log(offers);
//   });
// }

watchEffect(() => {
  console.log("useroffers");
  if (user.value && user.value.company) {
    console.log("useroffers2");

    store.dispatch("getMyOffers", { id: user.value.company.id });
  }
});
</script>

<style scoped lang="scss"></style>
