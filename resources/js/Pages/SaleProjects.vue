<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import inProgressOnIcon from '/public/icons/inProgressOn.svg';
    import inProgressOffIcon from '/public/icons/inProgressOff.svg';
    import completedOnIcon from '/public/icons/completedOn.svg';
    import completedOffIcon from '/public/icons/completedOff.svg';
    import ProjectListTable from '@/Components/ProjectListTable.vue';
    import { ref, computed } from 'vue';
    import { Head } from '@inertiajs/vue3';


    const viewType = ref('inProgress');

    // Function to set the current viewType
    function setViewType(type) {
        viewType.value = type;
    };

</script>
<template>
    <AuthenticatedLayout>
        <Head title="Projects" />

        <div class="progressButtons">
            <button :class="{ activeButton: viewType === 'inProgress' }" @click="setViewType('inProgress')"><img :src="viewType == 'inProgress'? inProgressOnIcon : inProgressOffIcon" :class="{ activeSvg: viewType === 'inProgress' }">In progress</button>
            <button :class="{ activeButton: viewType === 'completed' }" @click="setViewType('completed')"><img :src="viewType == 'completed'? completedOnIcon : completedOffIcon" :class="{ activeSvg: viewType === 'completed' }">Completed</button>
        </div>
        <div class="list">
            <ProjectListTable :progressStatus="viewType" :userRoles="$page.props.auth.user.user_roles"></ProjectListTable>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
    .progressButtons{
        width: 40vw;
        margin: 0 auto;
        margin-top: 2vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .progressButtons button{
        width: 170px;
        height: 40px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 5px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-around;
    }
    .activeButton{
        background-color: #0096ff;
        color: white;
    }
    .activeSvg path{
        fill: black;
    }
    .list{
        background-color: #fefeff;
        width: 90%;
        /* height: 80vh; */
        margin: 5px auto;
        box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
        border: 1px solid #f2ecec;
    }
</style>