<template>
  <PageComponent title="Admin Panel">
    <div class="grid grid-cols-1 gap-4">
      <div
        class="flex justify-between items-center py-3 px-5 shadow-md bg-sky-300 hover:bg-sky-200 dark:bg-sky-950 dark:hover:bg-sky-800 h-[80px]"
      >
        <router-link :to="{ name: 'Tags' }"> Manage Tags </router-link>
      </div>
    </div>
  </PageComponent>
</template>

<script setup>
import PageComponent from "../components/PageComponent.vue";
</script>

<style lang="scss" scoped></style>
