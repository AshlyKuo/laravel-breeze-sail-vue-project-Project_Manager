<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12 flex">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <button class="install">
                    <img src="" alt="">
                    <p>Installation<br>Management</p>
                </button>
                <button class="supply">
                    <img src="" alt="">
                    <p>Supply Chain<br>Management</p>
                </button>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
    /* div{
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }*/
    div button{
        background-color: #ccc;
        padding: 10px;
        margin: 20px;
    } 
</style>
