<template>
  <PageComponent title="Dashboard">
    <template v-slot:header>
      <div class="flex justify-between items-center py-5">
        <h1 class="text-3x1 font-bold">Company</h1>
        <span v-if="!user.company">
          <router-link
            :to="{ name: 'CompanyCreate' }"
            class="py-3 px-2 bg-yellow-900 hover:bg-yellow-800"
            >Create new company</router-link
          >
        </span>
        <span v-else>
          {{ user.company.name }}
          <router-link
            :to="{ name: 'CompanyCreate' }"
            class="py-3 px-2 bg-yellow-900 hover:bg-yellow-800"
            >Edit your company</router-link
          >
        </span>
      </div>
    </template>
    <div class="grid grid-cols-1 gap-4" v-if="offers.data.length > 0">
      <div v-for="offer in offers.data" :key="offer.id">
        <OfferPanel :offer="offer"></OfferPanel>
        <!-- <h4>
          <router-link :to="{ name: 'OfferView', params: { id: offer.id } }">{{
            offer.title
          }}</router-link>
        </h4>
        <h5>
          {{ offer.bracket_low }}-{{ offer.bracket_high }} {{ offer.currency }}
        </h5>
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
            class="h-8 w-8 items-center text-red-700 bg-red-300 dark:text-red-300 dark:bg-red-700"
          >
            X
          </button> 
        </div>-->
      </div>
    </div>

    <div
      class="grid grid-cols-1 gap-4 pt-5"
      v-if="companyApplications.data.length > 0"
    >
      <h3>Company Applications</h3>
      <div
        v-for="app in companyApplications.data"
        :key="app.id"
        class="flex justify-between items-center py-3 px-5 shadow-md bg-emerald-300 hover:bg-emerald-200 dark:bg-emerald-950 dark:hover:bg-emerald-800 h-[80px]"
      >
        <div class="flex flex-col justify-between items-center">
          <h4>
            {{ app.application }}
          </h4>
          <h4>
            {{ app.offer.title }}
          </h4>
        </div>
        <button
          v-if="app.resume"
          type="button"
          class="p-2 items-center bg-emerald-300 dark:bg-emerald-700"
          @click="downloadResume(app)"
        >
          Get Resume
        </button>
        <div>{{ app.user.email }}</div>
        <div class="flex flex-col justify-between items-center">
          <button
            type="button"
            @click="markAsRead(app)"
            class="p-2 items-center text-zinc-700 bg-zinc-300 dark:text-zinc-300 dark:bg-zinc-700"
          >
            Mark as read
          </button>
        </div>
      </div>
    </div>

    <div
      class="grid grid-cols-1 gap-4 pt-5"
      v-if="myApplications.data.length > 0"
    >
      <h3>My Applications</h3>
      <div
        v-for="app in myApplications.data"
        :key="app.id"
        class="flex justify-between items-center py-3 px-5 shadow-md bg-green-300 hover:bg-green-200 dark:bg-emerald-950 dark:hover:bg-emerald-800 h-[80px]"
      >
        <h4>
          <router-link
            :to="{ name: 'OfferView', params: { id: app.offer.id } }"
            class="cursor-pointer"
            >{{ app.offer.title }}</router-link
          >
        </h4>
        <div>{{ app.application }}</div>
        <div>{{ app.status }}</div>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import { ref, computed, watchEffect, onMounted, watch } from "vue";
import { getCompanyApplications } from "../service";
import { useStore } from "vuex";
import PageComponent from "../components/PageComponent.vue";
import OfferPanel from "../components/OfferPanel.vue";
const store = useStore();
import axiosClient from "../axios";

const user = computed(() => store.state.user.data);
let offers = computed(() => store.state.userOffers);
let myApplications = computed(() => store.state.myApplications);

let companyApplications = ref({
  data: [],
});

function downloadResume(app) {
  axiosClient
    .get(`/application/${app.id}/resume`, { responseType: "blob" })
    .then((res) => {
      const url = window.URL.createObjectURL(new Blob([res.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute(
        "download",
        `resume-${app.offer.slug}-${app.user.name}.pdf`
      );
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    });
}

onMounted(() => {
  if (user.value && user.value.company) {
    store.dispatch("getMyOffers", { id: user.value.company.id });
  }
  if (user.value && user.value.company) {
    getCompanyApplications().then((data) => {
      companyApplications.value = data;
    });
  }
  if (user.value) {
    store.dispatch("getMyApplications");
  }
});

// watch(
//   () => store.state.companyApplications.data,
//   (newVal, oldVal) => {
//     companyApplications.value.data = {
//       // ...JSON.parse(JSON.stringify(newVal)),
//       ...newVal,
//     };
//   }
// );

function markAsRead(app) {
  axiosClient
    .put(`/application/${app.id}`, { ...app, status: 1 })
    .then((res) => {
      const updatedApplication = res.data.data;
      const index = companyApplications.value.data.findIndex(
        (application) => application.id === updatedApplication.id
      );
      if (index !== -1) {
        companyApplications.value.data.splice(index, 1);
      }
    });
}
</script>

<style scoped lang="scss"></style>
