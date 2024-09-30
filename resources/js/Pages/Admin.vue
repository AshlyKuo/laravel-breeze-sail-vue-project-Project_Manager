<script setup>
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import AddUser from '@/Components/AddUser.vue'
    import UserListTable from '@/Components/UserListTable.vue';
    import { Head } from '@inertiajs/vue3'

    const currentView = ref('UserListTable');

    const components = {
        UserListTable,
        AddUser
    };

    const setCurrentView = (view) => {
        currentView.value = view;
    }

</script>
<template>
    <AuthenticatedLayout>
        <Head title="Admin" />
        <div class="adminWrapper">
            <div class="content">
                <UserListTable></UserListTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.content{
    background-color: #fefeff;
    width: 90%;
    /* height: 80vh; */
    margin: 5px auto;
    margin-top: 5vh;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
    border: 1px solid #f2ecec;

}

</style>