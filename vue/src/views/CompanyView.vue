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
      <div class="px-4 py-5 bg-white space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700">Image</label>
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
                class="h-[80%] w-[80%] text-gray-300"
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
          <label for="title" class="block text-sm font-medium text-gray-700"
            >Name</label
          >
          {{ model.name }}
        </div>
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700"
            >Status</label
          >
          {{ model.status }}
        </div>
        <div>
          <label
            for="description"
            class="block text-sm font-medium text-gray-700"
            >description</label
          >
          {{ model.description }}
        </div>

        <div>
          <label
            for="bracket_high"
            class="block text-sm font-medium text-gray-700"
            >address</label
          >

          {{ model.address }}
        </div>
        <div class="flex items-start">
          <div class="flex items-center h-5">
            {{ model.status }}
          </div>
          <div class="ml-3 text-sm">
            <label for="status" class="font-medium text-gray-700">Active</label>
          </div>
        </div>

        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6"></div>
      </div>
    </div>
  </PageComponent>
</template>
<script setup>
import { ref, computed, watch } from "vue";
import store from "../store";
import { useRoute } from "vue-router";
import PageComponent from "../components/PageComponent.vue";

const route = useRoute();
let model = ref({
  name: "",
  status: false,
  description: null,
  // image: "",
  image_url: "",
  offers: [],
  address: "",
  loc_x: null,
  loc_y: null,
});

const companyLoading = computed(() => store.state.currentCompany.loading);

watch(
  () => store.state.currentCompany.data,
  (newVal, oldVal) => {
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
</script>
<style lang=""></style>
