import { createStore } from "vuex";
import axiosClient from "../axios";

const tmpCompanies = [
    {
        id: 1,
        name: "Microsoft",
        slug: "microsoft",
        status: "active",
        description: "microsoft that one big company",
        image: "https://upload.wikimedia.org/wikipedia/commons/thumb/2/25/Microsoft_icon.svg/240px-Microsoft_icon.svg.png",
        created_at: "2023-05-27 18:00:00",
        updated_at: "2023-05-27 18:00:00",
        locale: null,
        offers: [],
    },
    {
        id: 2,
        name: "Apple Company",
        slug: "apple-company",
        status: "active",
        image: "https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/195px-Apple_logo_black.svg.png",
        description: "apple that one big company",
        created_at: "2023-05-27 18:00:00",
        updated_at: "2023-05-27 18:00:00",

        locale: null,
        offers: [],
    },
];
const tmpOffers = [
    {
        id: 1,
        title: "Front end",
        slug: "645767575675676575324-front-end-microsoft",
        description: "front end developer in microsoft",
        status: "active",
        bracket_low: 3000,
        bracket_high: 5000,
        image: "",
        created_at: "2023-05-27 18:00:00",
        updated_at: "2023-05-27 18:00:00",
        tags: ["Back end", "Laravel", "Mid"],
    },
    {
        id: 2,
        title: "Back end",
        slug: "54325423645654653654-back-end-apple",
        description: "front end developer in apple",
        status: "active",
        image: "",
        bracket_low: 10000,
        bracket_high: 15000,
        created_at: "2023-05-27 18:00:00",
        updated_at: "2023-05-27 18:00:00",
        tags: ["Back end", "Laravel", "Mid"],
    },
];

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
        offers: [...tmpOffers],
        companies: [...tmpCompanies],
        tags: [...tmpTags],
    },
    getters: {},
    actions: {
        register({ commit }, user) {
            return axiosClient.post("/register", user).then(({ data }) => {
                commit("setUser", data);
                return data;
            });
        },
        login({ commit }, user) {
            return axiosClient.post("/login", user).then(({ data }) => {
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
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.user;
            sessionStorage.setItem("TOKEN", userData.token);
        },
    },
    modules: {},
});

export default store;
