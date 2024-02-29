import { defineNuxtPlugin } from '#app'
import * as toast from "mosha-vue-toastify";
const { createToast } = toast

export default defineNuxtPlugin(() => {
  return {
    provide: {
      toast: createToast
    }
  }
})

