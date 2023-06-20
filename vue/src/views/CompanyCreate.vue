<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3x1 font-bold">
          {{ model.id ? model.name : "Create new company" }}
        </h1>
      </div>
    </template>
    <div v-if="companyLoading" class="flex justify-center">Loading...</div>

    <form v-else @submit.prevent="saveCompany">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-500">Image</label>
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
              <button
                type="button"
                class="relative overflow-hidden ml-5 bg-white dark:bg-gray-800 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <input
                  type="file"
                  @change="onImageChoose"
                  class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                />
                Change
              </button>
            </div>
          </div>
          <!--/ Image -->

          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-500"
              >Name</label
            >
            <input
              type="text"
              name="title"
              id="title"
              v-model="model.name"
              autocomplete="company_title"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-600"
            />
          </div>
          <div>
            <label for="title" class="block text-sm font-medium text-gray-500"
              >E-mail</label
            >
            <input
              type="text"
              name="email"
              id="email"
              v-model="model.email"
              autocomplete="company_email"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-600"
            />
          </div>

          <div>
            <label
              for="description"
              class="block text-sm font-medium text-gray-500"
              >description</label
            >
            <input
              type="text"
              name="description"
              id="description"
              v-model="model.description"
              autocomplete="company_description"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-600"
            />
          </div>

          <div>
            <label
              for="bracket_high"
              class="block text-sm font-medium text-gray-500"
              >address</label
            >
            <input
              type="text"
              name="bracket_high"
              id="bracket_high"
              v-model="model.address"
              autocomplete="company_bracket_high"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-slate-600"
            />
          </div>
          <div>
            <label for="title" class="block text-sm font-medium text-gray-500"
              >Location</label
            >
            <button
              autocomplete="company_location"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              @click.prevent="showMap = !showMap"
            >
              Show Map
            </button>
            <Map
              v-if="showMap"
              :x="model.loc_x"
              :y="model.loc_y"
              @setPos="setModelPos"
            ></Map>
          </div>
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <select
                name="status"
                v-model="model.status"
                id="status"
                class="mt-1 focus:ring-indigo-500 dark:bg-slate-600 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              >
                <option selected value="draft">draft</option>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
              </select>
            </div>
            <div class="ml-3 text-sm">
              <label for="status" class="font-medium text-gray-500"
                >Active</label
              >
            </div>
          </div>

          <div
            class="px-4 py-3 bg-gray-50 dark:bg-slate-600 text-right sm:px-6"
          >
            <button
              type="submit"
              class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </form>
    {{ model }}
  </PageComponent>
</template>
<script setup>
import { ref, watch, computed } from "vue";
import store from "../store";
import { useRoute, useRouter } from "vue-router";
import PageComponent from "../components/PageComponent.vue";
import Map from "../components/Map.vue";

const router = useRouter();
const route = useRoute();

const companyLoading = computed(() => store.state.currentCompany.loading);

let showMap = ref(false);
let model = ref({
  name: "",
  status: "draft",
  email: "",
  description: null,
  image: null,
  image_url: null,
  offers: [],
  address: "",
  loc_x: null,
  loc_y: null,
});

function saveCompany() {
  store.dispatch("saveCompany", model.value).then((data) => {
    router.push({
      name: "Dashboard",
    });
  });
}

watch(
  () => store.state.currentCompany.data,
  (newVal, oldVal) => {
    model.value = {
      // ...JSON.parse(JSON.stringify(newVal)),
      ...newVal,
      // status: newVal.status !== "draft",
    };
  }
);

function setModelPos(e) {
  model.value.loc_x = e.x;
  model.value.loc_y = e.y;
}

function onImageChoose(ev) {
  const file = ev.target.files[0];
  const reader = new FileReader();
  reader.onload = () => {
    model.value.image = reader.result;
    model.value.image_url = reader.result;
  };
  reader.readAsDataURL(file);
}
if (store.state.user.data.company) {
  store.dispatch("getCompany", store.state.user.data.company.id);
}
// if (store.state.user.data.company) {
//   model.value = { ...store.state.user.data.company };
// }
</script>
<style lang=""></style>
