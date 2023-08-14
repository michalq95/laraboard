<script setup>
import HelloWorld from "./components/HelloWorld.vue";
import DefaultLayout from "./components/DefaultLayout.vue";
import Chat from "./components/Chat.vue";
import store from "./store";
</script>

<template>
  <!-- <router-view></router-view> -->
  <DefaultLayout></DefaultLayout>
  <Chat v-if="store.state.user.token"></Chat>
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
