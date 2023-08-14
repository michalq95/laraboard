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

const echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_MIX_PUSHER_APP_KEY,
  wsHost: window.location.hostname,
  wsPort: 6001,
  forceTLS: false,
  disableStats: true,
  cluster: "eu",
  auth: {
    headers: {
      "X-CSRF-TOKEN": window.Laravel.csrfToken,

      Authorization: `Bearer ${store.state.user.token}`,
    },
  },
});

onMounted(() => {
  echo.channel("channel").listen(".chat", (e) => {
    chatMessages.value.push({ message: e.message, incoming: true });
  });
});

function onSubmit() {
  chatMessages.value.push({ message: input.value });
  input.value = "";
}

const input = ref("");
const showChat = ref(false);
const chatMessages = ref([
  { incoming: true, message: "Welcome to the chat" },
  { incoming: false, message: "Welcome to the chat" },
  {
    incoming: true,
    message:
      "Welcome to the chatWelcome to the chatWelcome to the chatWelcome to the chatWelcome to the chat",
  },
]);
</script>

<style lang="scss" scoped></style>
