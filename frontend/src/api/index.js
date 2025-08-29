import axios from "axios";
import router from "@/router";

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  headers: { "Content-Type": "application/json" },
  timeout: 10000,
});

axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response) {
      switch (error.response.status) {
        case 404:
          router.push({ name: "NotFound" });
          break;
        case 500:
          errorStore.triggerServerError(error);
          break;
      }
    }
    return Promise.reject(error);
  }
);

export default axiosInstance;
