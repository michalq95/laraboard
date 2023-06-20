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
      data: JSON.parse(sessionStorage.getItem("USER")) || {},
      token: sessionStorage.getItem("TOKEN"),
    },
    currentCompany: { loading: false, data: {} },
    currentOffer: { loading: false, data: {} },
    offers: { loading: false, data: [], links: [] },
    companies: { loading: false, data: [], links: [] },
    userOffers: { loading: false, data: [] },
    companyApplications: { data: [] },
    myApplications: { data: [] },
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
          if (res.data.application) {
            commit("setCurrentApplication", res.data.application ?? null);
          }
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
        response = axiosClient.put(`/offer/${offer.id}`, offer).then((res) => {
          return res.data;
        });
      } else {
        response = axiosClient.post(`/offer`, offer).then((res) => {
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
            commit("setUserCompany", res.data);
            return res.data;
          });
      } else {
        response = axiosClient.post(`/company`, company).then((res) => {
          commit("setUserCompany", res.data);
          return res.data;
        });
      }
      return response;
    },
    saveApplication({ commit }, appl) {
      let response = axiosClient.post(`/application`, appl).then((res) => {
        commit("setCurrentApplication", res.data.data);
        return res.data;
      });
      return response;
    },
    getOffers({ commit }, { keywords = null } = {}) {
      commit("setOffersLoading", true);
      return axiosClient
        .get("/offer/offers", { params: { keyword: keywords } })
        .then((res) => {
          console.log(res);
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
    getCompanyApplications({ commit }) {
      return axiosClient.get(`application/company`).then((res) => {
        commit("setCompanyApplications", res.data);
        return res;
      });
    },
    getMyApplications({ commit }) {
      return axiosClient.get(`application/application`).then((res) => {
        commit("setMyApplications", res.data);
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
      return axiosClient.post("/logout").then((data) => {
        commit("logout");

        return data;
      });
    },
  },
  mutations: {
    logout: (state) => {
      state.user.data = {};
      state.user.token = null;
      sessionStorage.removeItem("TOKEN");
      sessionStorage.removeItem("USER");
    },
    setUser: (state, userData) => {
      state.user.token = userData.token;
      state.user.data = userData.user;
      sessionStorage.setItem("USER", JSON.stringify(userData.user));

      sessionStorage.setItem("TOKEN", userData.token);
    },
    setUserCompany: (state, company) => {
      state.user.data.company = company.data;
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
    setCompanyApplications(state, data) {
      state.companyApplications.data = data.data;
    },
    setMyApplications(state, data) {
      state.myApplications.data = data.data;
    },
    setCurrentOffer(state, data) {
      state.currentOffer.data = data.data;
    },
    setCurrentApplication(state, data) {
      state.currentOffer.data.application = data;
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
