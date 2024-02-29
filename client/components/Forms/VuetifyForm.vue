<template>
    <form @submit.prevent="submit">
        <v-text-field
            v-model="name.value.value"
            :maxLength="20"
            :error-messages="name.errorMessage.value"
            label="Name"
        ></v-text-field>

        <v-autocomplete
            label="Country"
            :items="countries"
            :error-messages="country.errorMessage.value"
            item-title="name"
            item-value="id"
            v-model="country.value.value"
        >
            <template v-slot:chip="{ props, item }">
                <span style="margin: 0 10px 0 0;" v-html="item.raw.flag"></span>
                {{ item.raw.name }}
            </template>
            <template v-slot:item="{ props, item }">
                <v-list-item
                    v-bind="props"
                    :title="item.raw.name"
                >
                    <template v-slot:prepend>
                        <div style="margin: 0 10px 0 0;" v-html="item.raw.flag"></div>
                    </template>
                </v-list-item>
            </template>
        </v-autocomplete>

        <v-text-field
            v-model="phone.value.value"
            :error-messages="phone.errorMessage.value"
            label="Phone Number"
            :prefix="phonePrefix"
            :maxLength="12"
        ></v-text-field>

        <v-text-field
            v-model="email.value.value"
            :error-messages="email.errorMessage.value"
            label="E-mail"
        ></v-text-field>

        <v-btn
            :loading="loading"
            class="me-4"
            type="submit"
        >
            submit
        </v-btn>
    </form>
</template>
<script setup>
import {computed, ref, toRaw, watch} from 'vue'
import { useField, useForm } from 'vee-validate'
const config = useRuntimeConfig()
const {$toast} = useNuxtApp()
import { Mask } from "maska"

const { data: countriesList, pending, error, refresh } = await useAsyncData(
    () => $fetch(config.public.apiBase + 'countries'),
)
const countries = computed(() => toRaw(countriesList.value))

const { handleSubmit, handleReset } = useForm({
    validationSchema: {
        name (value) {
            if (value?.length >= 2) return true

            return 'Name needs to be at least 2 characters.'
        },
        phone (value) {
            if (value?.length > 9 && /^[0-9\-\+]{8,15}$/.test(value.replace(/\s*/g,""))) return true

            return 'Phone number needs to be at least 9 digits.'
        },
        email (value) {
            if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i.test(value)) return true

            return 'Must be a valid e-mail.'
        },
        country (value) {
            if (value) return true

            return 'Select an country.'
        },
    },
})
const phonePrefix = ref('')
const loading = ref(false)
const name = useField('name')
const phone = useField('phone')
const email = useField('email')
const country = useField('country')


watch(country.value, async (newValue, oldValue) => {
    if (newValue) {
        for (const country of countries.value) {
            if (country.id == newValue) {
                phonePrefix.value = country.idd
                return
            }
        }
    }
})
watch(phone.value, async (newValue, oldValue) => {
    if (newValue) {
        const phoneNum = newValue
        if (phoneNum.length > 12) newValue = oldValue
        newValue = phoneNum.replace(/[^0-9]/g, '')
        const mask = new Mask({ mask: "## ###-##-##" })
        phone.value.value = mask.masked(newValue)
    }
})

const submit = handleSubmit(values => {
    send(values)
})

async function send(data) {
    const form = new FormData();
    form.append('name', data.name)
    form.append('country_id', data.country)
    form.append('phone', phonePrefix.value + data.phone)
    form.append('email', data.email)
    await sendMail(form);
}

async function sendMail(form) {
    return fetch('/api/register', {
        method: 'POST',
        credentials: 'same-origin',
        body: form
    }).then(response => response.json())
      .then((data) => {
        handleReset()
        loading.value = false
        if (data.status === 'success') {
            showToastMessage('Succesfull registration', 'success')
            return
        }
        showToastMessage('Something went wrong', 'danger')
    }).catch(err => {
        console.log(err)
        handleReset()
        loading.value = false
        showToastMessage('Something went wrond', 'danger')
    })
}

function showToastMessage(message, type) {
    $toast(message, {
        position: 'top-right',
        timeout: 3000,
        transition: 'bounce',
        type: type,
        hideProgressBar: 'true',
        showIcon: 'true',
    })
}
</script>

<style scoped lang="scss">
</style>
