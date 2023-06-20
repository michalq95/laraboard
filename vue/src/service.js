import axiosClient from "./axios";

export function getCompanyApplications() {
  return axiosClient.get(`application/company`).then((res) => {
    //   commit("setCompanyApplications", res.data);
    return res.data;
  });
}
