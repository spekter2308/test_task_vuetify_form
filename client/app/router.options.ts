import type { RouterConfig } from "@nuxt/schema"

export default <RouterConfig>{
  routes: (_routes) => [
    {
      path: '/', name: '', component: () => import(`~/pages/index.vue`).then(m => m.default || m),
    }
  ]
}
