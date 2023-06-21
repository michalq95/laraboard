<template>
  <div v-if="offer.application">
    You applied to this offer on {{ offer.application.created_at }} The
    application status is {{ offer.application.status }}
  </div>

  <div v-else>
    <form @submit.prevent="saveApplication">
      <div class="shadow sm:rounded-md sm:overflow-hidden">
        <div class="px-4 py-5 bg-slate-300 dark:bg-slate-800 space-y-6">
          <div>
            <label
              for="application"
              class="block text-sm font-medium text-gray-500"
              >Application text</label
            >
            <input
              type="text"
              name="application"
              id="application"
              v-model="model.application"
              autocomplete="application"
              class="mt-1 dark:bg-slate-600 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-500"
              >Upload resume file</label
            >
            <div class="mt1 flex items-center">
              <button
                type="button"
                class="relative overflow-hidden ml-5 bg-white dark:bg-gray-800 py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <input
                  type="file"
                  accept=".pdf"
                  @change="onFileChoose"
                  class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                />
                Upload File
              </button>
            </div>
            <div
              class="px-4 py-3 bg-gray-50 dark:bg-sky-800 text-right sm:px-6"
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
      </div>
    </form>
    {{ model }}<br />
  </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import store from "../store";

const props = defineProps({
  offer: Object,
});

let model = ref({
  application: "In response to your offer I am enclosing a resume",
  resume: null,

  status: 0,
});

function onFileChoose(ev) {
  model.value.resume = ev.target.files[0];
}

function saveApplication() {
  const formData = new FormData();
  for (const field in model.value) {
    formData.append(field, model.value[field]);
  }
  formData.append("offer_id", props.offer.id);

  store.dispatch("saveApplication", formData).then((res) => {
    props.offer.application = res.data;
  });
}
</script>

<style lang="scss" scoped></style>
