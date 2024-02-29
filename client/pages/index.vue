<template>
    <div class="register page">
        <h2>Registration Form</h2>
        <VuetifyForm />
    </div>
</template>

<script setup>
import VuetifyForm from "~/components/Forms/VuetifyForm.vue";

</script>

<style scoped lang="scss">
 .register {
     padding: 20px 40px;
     margin: 0 auto;
     max-width: 800px;
     width: 100%;
     box-sizing: border-box;
     position: relative;
     box-sizing: border-box;

     h2 {
         color: #000;
         margin: 0 0 20px;
         text-align: center;
     }
 }
</style>
