import axios from "axios";
import store from "../store";

const axiosClient = axios.create({
  baseURL: 'http://thinktank.test/'
})
console.log(store.state.user.currentUser.token)
axiosClient.interceptors.request.use(config => {

    config.headers.Authorization = `Bearer ${store.state.user.currentUser.token}`
    console.log( config.headers)
  return config;
})

export default axiosClient;
