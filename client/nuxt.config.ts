// https://nuxt.com/docs/api/configuration/nuxt-config
import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'
export default defineNuxtConfig({
    devtools: { enabled: true },
    head: {
        htmlAttrs: {
            lang: 'en',
        },
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
            { name: 'format-detection', content: 'telephone=no' },
        ],
    },
    css: [
        'mosha-vue-toastify/dist/style.css'
    ],
    build: {
        transpile: ['vuetify'],
    },
    modules: [
        (_options, nuxt) => {
            nuxt.hooks.hook('vite:extendConfig', (config) => {
                // @ts-expect-error
                config.plugins.push(vuetify({ autoImport: true }))
            })
        },
        //...
    ],
    runtimeConfig: {
        public: {
            apiBase: process.env.APP_URL + '/api/',
            appUrl: process.env.APP_URL,
        }
    },
    vite: {
        vue: {
            template: {
                transformAssetUrls,
            },
        },
        css: {
            preprocessorOptions: {
                scss: {
                    includePaths: ['~/assets/scss'],
                }
            }
        },
        server: {
            watch: {
                usePolling: true,
            }
        },
    },
    nitro: {
        compressPublicAssets: {
            brotli: true,
        },
    }
})
