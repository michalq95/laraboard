import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import AdminPanel from "../views/AdminPanel.vue";
import Tags from "../views/Tags.vue";
import Register from "../views/Register.vue";
import Offers from "../views/Offers.vue";
import OfferView from "../views/OfferView.vue";
import OfferCreate from "../views/OfferCreate.vue";
import Companies from "../views/Companies.vue";
import CompanyCreate from "../views/CompanyCreate.vue";
import CompanyView from "../views/CompanyView.vue";
import NotFound from "../views/NotFound.vue";

import store from "../store";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";

const adminguard = async (to, from, next) => {
  if (store.getters.isMod) {
    next();
  } else {
    next({ name: "Dashboard" });
  }
};

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
    path: "/admin",
    name: "Admin",
    component: AdminPanel,
    meta: { requiresAuth: true },
    beforeEnter: adminguard,
  },
  {
    path: "/admin/tags",
    name: "Tags",
    component: Tags,
  },
  {
    path: "/",
    redirect: "/offers",
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true },
  },
  {
    path: "/dashboard/company",
    name: "DashboardCompany",
    component: CompanyView,
    meta: { requiresAuth: true },
  },
  { path: "/offers", name: "Offers", component: Offers },
  { path: "/companies", name: "Companies", component: Companies },

  {
    path: "/offers/create",
    name: "OfferCreateNew",
    component: OfferCreate,
    meta: { requiresAuth: true },
  },
  {
    path: "/offers/create/:id",
    name: "OfferCreate",
    component: OfferCreate,
    meta: { requiresAuth: true },
    beforeEnter: async (to, from, next) => {
      const res = await store.dispatch("getOffer", to.params.id);
      if (res.data.data.company_id == store.state.user.data.company.id) {
        next();
      } else {
        next({ name: "OfferView", params: { id: to.params.slug } });
      }
    },
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
    meta: { requiresAuth: true },
  },
  {
    path: "/companies/:id",
    name: "CompanyView",
    component: CompanyView,
  },
  { path: "/404", name: "NotFound", component: NotFound },
  { path: "/:pathMatch(.*)*", redirect: { name: "NotFound" } },
  // ],
  //   },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.name != "NotFound") store.commit("setError", false);
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({ name: "Login" });
  } else if (store.state.user.token && to.meta.isGuest) {
    next({ name: "Dashboard" });
  } else {
    next();
  }
});

export default router;
