import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Register from "../views/Register.vue";
import Offers from "../views/Offers.vue";
import OfferView from "../views/OfferView.vue";
import Companies from "../views/Companies.vue";
import CompanyCreate from "../views/CompanyCreate.vue";
import CompanyView from "../views/CompanyView.vue";

import store from "../store";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";

const routes = [
  {
    path: "/auth",
    name: "Auth",
    redirect: "/login",
    component: AuthLayout,
    meta: {
      isGuest: true,
    },
    children: [
      { path: "/login", name: "Login", component: Login },
      { path: "/register", name: "Register", component: Register },
    ],
  },
  {
    path: "/",
    redirect: "/dashboard",
    name: "DefaultLayout",
    component: DefaultLayout,
    meta: { requiresAuth: true },
    children: [
      { path: "/dashboard", name: "Dashboard", component: Dashboard },
      {
        path: "/dashboard/company",
        name: "DashboardCompany",
        component: CompanyView,
      },
      { path: "/offers", name: "Offers", component: Offers },
      { path: "/companies", name: "Companies", component: Companies },

      {
        path: "/offers/create",
        name: "OfferCreate",
        component: OfferView,
      },
      {
        path: "/offers/:id",
        name: "OfferView",
        component: OfferView,
      },
      {
        path: "/companies/create",
        name: "CompanyCreate",
        component: CompanyCreate,
      },
      {
        path: "/companies/:id",
        name: "CompanyView",
        component: CompanyView,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: "Login" });
  } else if (store.state.user.token && to.meta.isGuest) {
    next({ name: "Dashboard" });
  } else {
    next();
  }
});

export default router;
