import { defineStore } from "pinia";
import { ref } from "vue";

export const useErrorStore = defineStore("error", () => {
  const error = ref(null); // store error info
  const showServerError = ref(false);

  function triggerServerError(err) {
    error.value = err;
    showServerError.value = true;
  }

  function clearError() {
    error.value = null;
    showServerError.value = false;
  }

  return { error, showServerError, triggerServerError, clearError };
});
