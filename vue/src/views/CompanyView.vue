<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3x1 font-bold">
          {{ model.id }}
        </h1>
      </div>
    </template>
    <div v-if="companyLoading" class="flex justify-center">Loading...</div>

    <div v-else class="shadow sm:rounded-md sm:overflow-hidden">
      <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6">
        <div>
          <div class="mt1 flex items-center">
            <img
              v-if="model.image_url"
              :src="model.image_url"
              :alt="model.name"
              class="w-64 object-cover"
            />
            <span
              v-else
              class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-[80%] w-[80%] text-gray-500"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
          </div>
        </div>
        <!--/ Image -->

        <!-- Title -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-500"
            >Name</label
          >
          {{ model.name }}
        </div>

        <div>
          <label
            for="description"
            class="block text-sm font-medium text-gray-500"
            >description</label
          >
          {{ model.description }}
        </div>

        <div>
          <label
            for="bracket_high"
            class="block text-sm font-medium text-gray-500"
            >address</label
          >

          {{ model.address }}
        </div>

        <div class="grid grid-cols-1 gap-4" v-if="offers">
          <div v-for="offer in offers" :key="offer.id">
            <OfferPanel :offer="{ ...offer, company: model }"></OfferPanel>
          </div>
        </div>

        <!-- <div
          class="px-4 py-3 bg-gray-50 dark:bg-sky-800 text-right sm:px-6"
        ></div> -->
      </div>
    </div>
  </PageComponent>
</template>
<script setup>
import { ref, computed, watch } from "vue";
import store from "../store";
import { useRoute } from "vue-router";
import PageComponent from "../components/PageComponent.vue";
import OfferPanel from "../components/OfferPanel.vue";
import { onMounted } from "vue";
import axiosClient from "../axios";

const route = useRoute();
let model = ref({
  name: "",
  status: false,
  description: null,
  // image: "",
  image_url: "",
  // offers: [],
  address: "",
  loc_x: null,
  loc_y: null,
});
let offers = ref([]);

const companyLoading = computed(() => store.state.currentCompany.loading);

watch(
  () => store.state.currentCompany.data,
  (newVal, oldVal) => {
    axiosClient.get(`company/${newVal.id}/offer`).then((res) => {
      offers.value = res.data.data;
    });
    model.value = {
      // ...JSON.parse(JSON.stringify(newVal)),
      ...newVal,
      status: newVal.status !== "draft",
    };
  }
);

if (route.params.id) {
  store.dispatch("getCompany", route.params.id);
}
// onMounted(() => {
//   axiosClient.get(`company/${route.params.id}/offer`).then((res) => {
//     console.log(res);
//     offers.value = res.data.data;
//   });
// });
</script>
<style lang=""></style>
