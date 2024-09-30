<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';
import closeIcon from '/public/icons/close.svg'

const emits = defineEmits(['closeForm']);
const closeForm = () => {
    emits('closeForm', false);
};


const form = useForm({
    name: '',
    email: '',
    user_roles: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {

    const email = form.email;
    
    const atIndex = email.indexOf("@");

    if (atIndex !== -1) {
        const passwordString = email.substring(0, atIndex);
        const password = passwordString + passwordString;

        form.password = password;
        form.password_confirmation = password;

        form.user_roles = Number(form.user_roles);
    }

    form.post(route('addUser'), {
        onFinish: () => {
            form.reset('name', 'email', 'user_roles', 'password', 'password_confirmation');
            emits('closeForm', false);
        },
    });
};


</script>

<template>
    <div class="addUserWrapper"> 
        <div class="form">
            <button class="closeBtn" @click="closeForm"><img :src=closeIcon alt=""></button>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mt-4">
                    <label for="user_roles" class="block font-medium text-sm text-gray-700">User Role</label>
                    <select name="user_roles" id="role-select" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required v-model="form.user_roles"> 
                        <option value="">--Please choose user role--</option>
                        <option value=1>MIS</option>
                        <option value=2>Chairman</option>
                        <option value=3>MJ</option>
                        <option value=4>Addwii</option>
                    </select>
                </div>
                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Add New User
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>

</template>
<style scoped> 
.addUserWrapper{
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background-color: rgba(225, 225, 225, 0.7);
    z-index: 999;

}
.form{
    position: relative;
    width: 50%;
    height: 50%;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
}
.closeBtn{
    position: absolute;
    right: 15px;
    top: 10px;
    width: 26px;
}

form{
    /* width: 50%;
    margin: 0 auto;
    margin-top: 20px; */
}
</style>