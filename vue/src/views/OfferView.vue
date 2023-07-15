<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3x1 font-bold">
          {{ model.id ? model.title : "Create new offer" }}
        </h1>
      </div>
    </template>

    <div>
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6">
          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-500"
              >Title</label
            >
            <span
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              >{{ model.title }}
            </span>
          </div>
          <div>
            <label for="status" class="block text-sm font-medium text-gray-500"
              >Status</label
            >
            <span
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              >{{ model.status }}</span
            >
          </div>
          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-500"
              >description</label
            >
            <span
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              >{{ model.description }}</span
            >
          </div>
          <div>
            <span
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              >{{ model.bracket_low }}-{{ model.bracket_high }}
              {{ model.currency }}</span
            >
          </div>

          <div>
            <label
              for="bracket_high"
              class="block text-sm font-medium text-gray-500"
              >Offer ending at</label
            >
            <span
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              >{{ model.expire_date }}</span
            >
          </div>

          <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">
            <div class="flex flex-wrap">
              <span
                v-for="tag in model.tags"
                class="text-center text-gray-600 dark:text-gray-200 p-5"
              >
                {{ tag }}
              </span>
            </div>
          </div>
        </div>
      </div>
      <Apply v-if="store.state?.user.token" :offer="model"></Apply>
    </div>
  </PageComponent>
</template>
<script setup>
import { ref, computed, watch } from "vue";
import store from "../store";
import { useRoute } from "vue-router";
import PageComponent from "../components/PageComponent.vue";
import Apply from "../components/Apply.vue";

const route = useRoute();
let model = ref({
  title: "",
  status: "",
  description: null,
  bracket_low: null,
  bracket_high: null,
  currency: "",
  tags: [],
  application: null,
});
let filterText = ref("");
let selected = null;

watch(
  () => store.state.currentOffer.data,
  (newVal, oldVal) => {
    model.value = {
      // ...JSON.parse(JSON.stringify(newVal)),
      ...newVal,
    };
  }
);
// if (route.params.id) {
//   model.value = store.state.offers.find(
//     (s) => s.id === parseInt(route.params.id)
//   );
// }
if (route.params.id) {
  store.dispatch("getOffer", route.params.id);
}
</script>
<style lang=""></style>
