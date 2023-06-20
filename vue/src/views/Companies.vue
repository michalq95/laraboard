<template>
  <PageComponent>
    <template v-slot:header>
      <div class="flex justify-between items-center">
        <h1 class="text-3x1 font-bold">Companies</h1>
        <router-link
          v-if="store.state.user.token"
          :to="{ name: 'CompanyCreate' }"
          class="py-3 px-2 bg-yellow-900 hover:bg-yellow-800"
          ><span v-if="!store.state.user.data.company">Create new company</span
          ><span v-else>Edit your company</span></router-link
        >
      </div>
    </template>
    <div class="grid grid-cols-1 gap-4">
      <div
        v-for="company in companies"
        :key="company.id"
        class="flex justify-between items-center py-3 px-5 shadow-md dark:bg-sky-900 dark:hover:bg-sky-700 h-[80px]"
      >
        <img :src="company.image_url" alt="" class="w-8 object-cover" />
        <h4>
          <router-link
            :to="{ name: 'CompanyView', params: { id: company.id } }"
          >
            {{ company.name }}</router-link
          >
        </h4>
        <div v-if="company.id === userCompanyId">
          <router-link
            :to="{ name: 'CompanyCreate' }"
            class="py-2 px-2 rounded-lg bg-blue-500 hover:bg-blue-400 dark:bg-blue-800 dark:hover:bg-blue-700"
            >Edit company</router-link
          >
        </div>
        <div></div>
      </div>
    </div>
  </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import store from "../store";
import { computed } from "vue";

const companies = computed(() => store.state.companies.data);
const userCompanyId = computed(() => store.state.user?.data?.company?.id);

store.dispatch("getCompanies");
</script>
<style lang=""></style>
