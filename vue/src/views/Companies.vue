<template>
    <PageComponent>
        <template v-slot:header>
            <div class="flex justify-between items-center">
                <h1 class="text-3x1 font-bold">Companies</h1>
                <router-link
                    :to="{ name: 'CompanyCreate' }"
                    class="py-3 px-2 bg-yellow-300 rounded-lg hover:bg-yellow-400"
                    >Create new company</router-link
                >
            </div>
        </template>
        <div class="grid grid-cols-1 gap-4">
            <div
                v-for="company in companies"
                :key="company.id"
                class="flex justify-between items-center py-3 px-5 shadow-md bg-blue-300 hover:bg-blue-300 h-[80px]"
            >
                <img :src="company.image" alt="" class="w-8 object-cover" />
                <h4>{{ company.name }}</h4>
            </div>
        </div>
    </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import store from "../store";
import { computed } from "vue";
const companies = computed(() => store.state.companies);
</script>
<style lang=""></style>
