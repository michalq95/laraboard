<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3x1 font-bold">Tags</h1>
      </div>
    </template>
    <div>
      <button
        type="button"
        @click="showAll = !showAll"
        class="my-3 p-2 bg-blue-300 dark:bg-blue-700"
      >
        {{ !showAll ? "Show All" : "Only Pending" }}
      </button>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div
          v-for="tag in displayedTags"
          :key="tag.id"
          class="flex justify-between items-center py-3 px-5 shadow-md dark:bg-sky-900 dark:hover:bg-sky-700 h-[40px]"
        >
          <input
            type="checkbox"
            :value="tag.id"
            :id="'checkbox' + tag.id"
            v-model="checked"
          />
          <div>
            {{ tag.name }}
          </div>
          <div>
            {{ tag.accepted }}
          </div>
        </div>
      </div>
      <button
        type="button"
        @click="acceptTags()"
        class="my-3 p-2 items-center bg-blue-300 dark:bg-blue-700"
      >
        Accept Tags
      </button>
    </div>
  </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import axiosClient from "../axios";

import store from "../store";
import { computed, onMounted, ref } from "vue";

let showAll = ref(true);
let allTags = ref([]);
let checked = ref([]);
let displayedTags = computed(() =>
  showAll.value ? allTags.value : allTags.value.filter((t) => t.accepted)
);

onMounted(() => {
  axiosClient.get(`/tag/all`).then((res) => {
    allTags.value = res.data;
  });
});

function acceptTags() {
  axiosClient.put(`/tag`, { tag_ids: checked.value }).then((res) => {
    checked.value = [];
  });
}
</script>
<style lang=""></style>
