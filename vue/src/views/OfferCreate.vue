<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex items-center justify-between">
        <h1 class="text-3x1 font-bold">
          {{ model.id ? model.title : "Create new offer" }}
        </h1>
        <button
          v-if="route.params.id"
          type="button"
          @click="deleteOffer()"
          class="py-2 px-3 bg-red-400 rounded-md"
        ></button>
      </div>
    </template>

    <form @submit.prevent="saveOffer">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-slate-300 dark:bg-slate-800 space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-500">Image</label>
            <div class="mt1 flex items-center">
              <img
                v-if="model.image"
                :src="model.image"
                :alt="model.title"
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
              >Title</label
            >
            <input
              type="text"
              name="title"
              id="title"
              v-model="model.title"
              autocomplete="offer_title"
              class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
          </div>
          <div>
            <label for="status" class="block text-sm font-medium text-gray-500"
              >Status</label
            >
            <select
              name="status"
              v-model="model.status"
              id="status"
              class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            >
              <option selected value="draft">draft</option>
              <option value="active">active</option>
              <option value="inactive">inactive</option>
            </select>
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
              autocomplete="offer_description"
              class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
          </div>
          <div>
            <div class="w-1/3 inline-block pr-4">
              <label
                for="bracket_low"
                class="block text-sm font-medium text-gray-500"
                >bracket_low</label
              >
              <input
                type="number"
                name="bracket_low"
                id="bracket_low"
                v-model="model.bracket_low"
                autocomplete="offer_bracket_low"
                class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              />
            </div>

            <div class="w-1/3 inline-block px-2">
              <label
                for="bracket_high"
                class="block text-sm font-medium text-gray-500"
                >bracket_high</label
              >
              <input
                type="number"
                name="bracket_high"
                id="bracket_high"
                v-model="model.bracket_high"
                autocomplete="offer_bracket_high"
                class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              />
            </div>
            <div class="w-1/3 inline-block pl-4">
              <label
                for="Currency"
                class="block text-sm font-medium text-gray-500"
                >Currency</label
              >
              <input
                type="text"
                name="currency"
                id="currency"
                v-model="model.currency"
                autocomplete="offer_currency"
                class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
              />
            </div>
          </div>
          <div>
            <label for="icon" class="text-sm font-medium text-gray-500"
              >Icon</label
            >
            <div class="flex flex-wrap justify-center">
              <div v-for="(icon, i) in icons" :key="i" class="text-left p-3">
                <img :src="icon.image" class="w-10 object-cover float-left" />
                <input
                  type="radio"
                  name="icon"
                  :id="i"
                  v-model="model.icon"
                  :value="icon.value"
                  autocomplete="icon"
                  class="border-gray-300 rounded-md my-3"
                />
                <label :for="i"> {{ icon.value }}</label>
              </div>
            </div>
          </div>

          <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">
            <h3
              class="text-2xl font-semibold flex items-center justify-between"
            >
              Tags

              <select
                id="available_tags"
                name="available_tags"
                v-model="selected"
                @change="addTag()"
                class="dark:bg-slate-600 mt-1 focus:ring-indigo-500 focus:border-indigo-500 ring-indigo-400 border-indigo-00 block w-60 shadow-sm sm:text-sm rounded-md"
              >
                <option value="tags" disabled hidden selected>tags</option>
                <option v-for="tag in availableTags" :key="tag" :value="tag">
                  {{ tag }}
                </option>
              </select>

              <input
                v-model="filterText"
                type="text"
                class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 ring-indigo-400 border-indigo-00 block w-60 shadow-sm sm:text-sm rounded-md"
              />
              <button
                type="button"
                @click="addCustomTag()"
                class="flex items-center text-sm py-1 px-4 rounded-sm text-white bg-gray-600 hover:bg-gray-700"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd"
                  />
                </svg>
                Add Tag
              </button>
            </h3>
            <div class="flex flex-wrap">
              <span
                v-for="tag in model.tags"
                class="text-center text-gray-600 p-5"
              >
                {{ tag
                }}<span
                  @click="removeTag(tag)"
                  class="bg-red-500 border-red-600 rounded-full px-2 cursor-pointer"
                  >X</span
                >
              </span>
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 dark:bg-sky-800 text-right sm:px-6">
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
  </PageComponent>
</template>
<script setup>
import { ref, computed, watch, onMounted } from "vue";
import store from "../store";
import { useRoute, useRouter } from "vue-router";
import PageComponent from "../components/PageComponent.vue";
import axiosClient from "../axios";
const router = useRouter();

const route = useRoute();
let model = ref({
  title: "",
  company_id: store.state?.user.data.company.id,
  status: "draft",
  description: null,
  bracket_low: null,
  bracket_high: null,
  currency: "",
  icon: null,
  tags: [],
});
let allTags = ref([]);
let filterText = ref("");
let selected = null;

function addTag() {
  model.value.tags.push(selected);
}

function addCustomTag() {
  let trimmed = filterText.value.trim();
  if (trimmed) model.value.tags.push(filterText.value);
  filterText.value = "";
}

function removeTag(tag) {
  model.value.tags = model.value.tags.filter((el) => el !== tag);
}
function saveOffer() {
  store
    .dispatch("saveOffer", { ...model.value, tags: model.value.tags.join() })
    .then((data) => {
      router.push({
        name: "Dashboard",
      });
    });
}

onMounted(() => {
  if (route.params.id) model.value = store.state.currentOffer.data;
  axiosClient.get(`/tag`).then((res) => {
    allTags.value = res.data.tags.map((el) => el.name);
  });
});

function deleteOffer() {
  if (confirm("Delete this offer?")) {
    store.dispatch("deleteOffer", model.value.id).then(() => {
      router.push({
        name: "Dashboard",
      });
    });
  }
}

let availableTags = computed(() => {
  return allTags.value
    .filter((el) => !model.value.tags.includes(el))
    .filter((el) => el.toLowerCase().includes(filterText.value.toLowerCase()));
});

// watch(
//   () => store.state.currentOffer.data,
//   (newVal, oldVal) => {
//     model.value = {
//       ...newVal,
//     };
//   }
// );

const icons = [
  { value: "js", image: "../../src/assets/icons/js.png" },
  { value: "php", image: "../../src/assets/icons/php.png" },
  { value: "python", image: "../../src/assets/icons/python.png" },
  { value: "vue", image: "../../src/assets/icons/vue.png" },
  { value: "java", image: "../../src/assets/icons/java.png" },
];

// if (route.params.id) {
//   store.dispatch("getOffer", route.params.id);
// }
</script>
<style lang=""></style>
