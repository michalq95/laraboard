<template>
  <div class="fixed bg-slate-300 right-0 bottom-12 text-left">
    <!-- <div class="h-10 w-10" v-if="showChat"> -->
    <button
      @click="showChat = !showChat"
      class="h-10 w-10 text-red-700 bg-red-300"
    >
      Chat
    </button>
    <!-- </div> -->
    <div class="h-96 w-72" v-if="showChat">
      <ul class="overflow-y-scroll h-[88%]">
        <li v-for="m in chatMessages" class="list-none text-black">
          <div v-if="m.incoming" class="text-right">{{ m.message }}</div>
          <div v-else class="text-left">{{ m.message }}</div>
        </li>
      </ul>
      <form @submit.prevent="onSubmit" class="h-[12%]">
        <input
          class="w-4/5 text-black"
          type="text"
          placeholder="Your message..."
          v-model="input"
        />
        <button class="bg-slate-800 h-full">Send</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Echo from "laravel-echo";
import store from "../store";
import axiosClient from "../axios";

const echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_MIX_PUSHER_APP_KEY,
  wsHost: import.meta.env.VITE_WEBSOCKET_SERVER,
  wssHost: import.meta.env.VITE_WEBSOCKET_SERVER,
  // wsHost: "127.0.0.1",
  wsPort: 6001,
  forceTLS: false,
  disableStats: true,
  cluster: "eu",
  authEndpoint: "http://127.0.0.1:8000/api/broadcasting/auth",
  // enabledTransports: [""],
  // enabledTransports: ["ws", "wss"],
  auth: {
    headers: {
      // "X-CSRF-TOKEN": window.Laravel.csrfToken,
      Accept: "application/json",
      Authorization: `Bearer ${store.state.user.token}`,
    },
  },
});

onMounted(() => {
  echo.channel("channel").listen(".chat", (e) => {
    chatMessages.value.push({ message: e.message, incoming: true });
  });
  echo
    .private(`chat.${store.state.user.data.id}`)
    .listen(".chat.private", (e) => {
      chatMessages.value.push({ message: e.message, incoming: true });
    });
});

function onSubmit() {
  let trimmed = input.value.trim();
  if (trimmed) {
    // model.value.tags.push(filterText.value);
    chatMessages.value.push({ message: input.value });
    axiosClient.post("/chat", { message: input.value });
    input.value = "";
  }
}

const input = ref("");
const showChat = ref(false);
const chatMessages = ref([
  { incoming: true, message: "Ask question to our AI model" },
]);
</script>

<style lang="scss" scoped></style>
