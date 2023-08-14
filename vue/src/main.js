import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import "./index.css";
import Pusher from "pusher-js";
window.Vue = createApp;
Vue.router = router;

createApp(App).use(store).use(router).mount("#app");
