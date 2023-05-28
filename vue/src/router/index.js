import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Register from "../views/Register.vue";

const routes = [
    { path: "/login", name: "Login", component: Login },
    { path: "/register", name: "Register", component: Register },
    { path: "/dashboard", name: "Dashboard", component: Dashboard },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
