<template>
  <div
    class="flex justify-between items-center py-3 px-5 shadow-md bg-sky-300 hover:bg-sky-200 dark:bg-sky-950 dark:hover:bg-sky-800 h-[80px]"
  >
    <div>
      <img
        v-if="offer.company.image_url"
        :src="offer.company.image_url"
        class="w-8 object-cover"
      />
      <img v-else src="../assets/placeholder.jpg" class="w-8 object-cover" />
    </div>
    <div class="flex flex-col flex-grow p-2">
      <div class="flex justify-between">
        <h4>
          <router-link :to="{ name: 'OfferView', params: { id: offer.id } }">{{
            offer.title
          }}</router-link>
        </h4>

        <h5 class="items-end">
          {{ offer.bracket_low }}-{{ offer.bracket_high }}
          {{ offer.currency }}
        </h5>
      </div>

      <div class="flex justify-between">
        <h4>
          <router-link
            :to="{ name: 'CompanyView', params: { id: offer.company.id } }"
          >
            {{ offer.company.name }}
          </router-link>
        </h4>
        <div>
          <span v-for="tag in offer.tags.slice(0, 3)" class="pl-2">
            {{ tag }}
          </span>
        </div>
      </div>
    </div>
    <div
      v-if="offer.company_id === userCompanyId"
      class="flex flex-col justify-between items-center"
    >
      <router-link
        :to="{ name: 'OfferCreate', params: { id: offer.id } }"
        class="py-2 px-2 bg-sky-300 hover:bg-sky-200 dark:bg-sky-900 dark:hover:bg-sky-700 rounded-lg"
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
</template>

<script setup>
import store from "../store";
import { computed } from "vue";

const props = defineProps({
  offer: Object,
});
const userCompanyId = computed(() => store.state.user?.data?.company?.id);
</script>

<style lang="scss" scoped></style>
