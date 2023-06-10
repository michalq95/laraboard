import { createStore } from "vuex";
import axiosClient from "../axios";

const tmpTags = [
  "Back end",
  "Laravel",
  "Mid",
  "Front end",
  "Vue",
  "Junior",
  "Python",
  "Java",
  "JavaScript",
];

const store = createStore({
  state: {
    user: {
      data: {},
      token: sessionStorage.getItem("TOKEN"),
    },
    currentCompany: { loading: false, data: {} },
    currentOffer: { loading: false, data: {} },
    offers: { loading: false, data: [], links: [] },
    companies: { loading: false, data: [], links: [] },
    userOffers: { loading: false, data: [] },
    tags: [...tmpTags],
  },
  getters: {},
  actions: {
    getOffer({ commit }, id) {
      commit("setCurrentOfferLoading", true);
      return axiosClient
        .get(`/offer/${id}`)
        .then((res) => {
          commit("setCurrentOffer", res.data);
          commit("setCurrentOfferLoading", false);
          return res;
        })
        .catch((err) => {
          commit("setCurrentOfferLoading", false);
          throw err;
        });
    },
    getCompany({ commit }, id) {
      commit("setCurrentCompanyLoading", true);
      return axiosClient
        .get(`/company/${id}`)
        .then((res) => {
          commit("setCurrentCompany", res.data);
          commit("setCurrentCompanyLoading", false);
          return res;
        })
        .catch((err) => {
          commit("setCurrentCompanyLoading", false);
          throw err;
        });
    },
    getCompanies({ commit }) {
      commit("setCompaniesLoading", true);
      return axiosClient.get("/company").then((res) => {
        commit("setCompaniesLoading", false);
        commit("setCompanies", res.data);
        return res;
      });
    },
    saveOffer({ commit }, offer) {
      delete offer.image_url;
      let response;
      if (offer.id) {
        console.log("put");
        console.log(offer);
        response = axiosClient.put(`/offer/${offer.id}`, offer).then((res) => {
          console.log(res);
          return res.data;
        });
      } else {
        response = axiosClient.post(`/offer`, offer).then((res) => {
          console.log(res.data);
          return res.data;
        });
      }
      return response;
    },
    saveCompany({ commit }, company) {
      delete company.image_url;
      let response;
      if (company.id) {
        response = axiosClient
          .put(`/company/${company.id}`, company)
          .then((res) => {
            // this.commit("updateCompany", res.data);
            console.log(res);
            return res.data;
          });
      } else {
        response = axiosClient.post(`/company`, company).then((res) => {
          // this.commit("updateCompany", res.data);
          console.log(res.data);
          return res.data;
        });
      }
      return response;
    },
    getOffers({ commit }, { url = null } = {}) {
      url = url || "/offer/offers";
      commit("setOffersLoading", true);
      return axiosClient.get(url).then((res) => {
        commit("setOffersLoading", false);
        commit("setOffers", res.data);
        return res;
      });
    },
    getMyOffers({ commit }, { id }) {
      // url = url || "/offer/offers";
      commit("setUserOffersLoading", true);
      return axiosClient.get(`company/${id}/offer`).then((res) => {
        commit("setUserOffersLoading", false);
        commit("setUserOffers", res.data);
        return res;
      });
    },
    register({ commit }, user) {
      return axiosClient.post("/register", user).then(({ data }) => {
        commit("setUser", data);
        return data;
      });
    },
    login({ commit }, user) {
      return axiosClient.post("/login", user).then(({ data }) => {
        console.log(data);
        commit("setUser", data);
        return data;
      });
    },
    logout({ commit }) {
      commit("logout");
      return axiosClient.post("/logout").then((data) => {
        return data;
      });
    },
  },
  mutations: {
    logout: (state) => {
      state.user.data = {};
      state.user.token = null;
      sessionStorage.removeItem("TOKEN");
    },
    setUser: (state, userData) => {
      state.user.token = userData.token;
      state.user.data = userData.user;
      sessionStorage.setItem("TOKEN", userData.token);
    },

    setCurrentCompanyLoading(state, status) {
      state.currentCompany.loading = status;
    },
    setCompaniesLoading(state, status) {
      state.companies.loading = status;
    },
    setCurrentOfferLoading(state, status) {
      state.currentOffer.loading = status;
    },
    setOffersLoading(state, status) {
      state.offers.loading = status;
    },
    setUserOffersLoading(state, status) {
      state.userOffers.loading = status;
    },

    setCurrentCompany(state, data) {
      state.currentCompany.data = data.data;
    },
    setCompanies(state, data) {
      state.companies.data = data.data;
    },
    setCurrentOffer(state, data) {
      state.currentOffer.data = data.data;
    },
    setOffers(state, data) {
      state.offers.data = data.data;
    },
    setUserOffers(state, data) {
      state.userOffers.data = data.data;
    },
  },
  modules: {},
});

export default store;
