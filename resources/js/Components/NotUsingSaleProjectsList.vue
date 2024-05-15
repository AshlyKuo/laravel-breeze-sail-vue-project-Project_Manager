<script setup>
    import { ref, computed, defineProps } from 'vue';
    import inProgressIcon from '/public/icons/inProgress.svg';
    import NewProjectLightBox from './NewProjectLightBox.vue';
    import ProjectListTable from './ProjectListTable.vue';

    const isEditable = ref(true);
    const newProjectLightBoxDisplay = ref(false);
    const props = defineProps({
        progressStatus: String,
    });
    const filteredProjects = ref(
        [
            {date: '2023/11/2', caseID: 'A739kr', location: 'New York', customerName: 'Kelly', currentProgress: 4, status: 'Installation'},
            {date: '2024/11/2', caseID: 'A734dr', location: 'Chicago', customerName: 'Allen', currentProgress: 5, status: 'Installation'},
            {date: '2023/11/20', caseID: 'A749kr', location: 'Los Angeles', customerName: 'Juy', currentProgress: 1, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 2, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 6, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 4, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 2, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 3, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 5, status: 'Installation'},
            {date: '2023/1/2', caseID: 'A739kr', location: 'Taipei', customerName: 'Adam', currentProgress: 1, status: 'Installation'},

        ]
    )
    function editProject(){

    }
    function toggleLightBox(){
        newProjectLightBoxDisplay.value = ! newProjectLightBoxDisplay.value;
    }

</script>

<template>
    <ProjectListTable></ProjectListTable>
    <div class="saleProjectsList" style="display: none;">
        <NewProjectLightBox v-if="newProjectLightBoxDisplay"></NewProjectLightBox>
        <div style="height: 5%;">
            <input type="search" placeholder="Search" />
            <button @click="toggleLightBox">New Project</button>
        </div>
        <div class="flex justify-between" style="height: 5%;"> 
            <h2>{{ progressStatus == 'completed' ? 'Completed' : 'In Progress' }} Project: {{ filteredProjects.length }}</h2>
            <!-- <select v-if="isEditable">
                <option>Sort by time</option>
            </select> -->
        </div>
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Case ID</th>
                        <th>Location</th>
                        <th>Customer Name</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th v-if="isEditable"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="project in filteredProjects" :key="project.caseID">
                        <td>{{ project.date }}</td>
                        <td>{{ project.caseID }}</td>
                        <td>{{ project.location }}</td>
                        <td>{{ project.customerName }}</td>
                        <td>
                        <div class="progress">
                            <span v-for="n in 6" :key="n" :class="{ 'active': n <= project.currentProgress }">{{ n }}</span>
                        </div>
                        </td>
                        <td>{{ project.status }}</td>
                        <td v-if="isEditable">
                        <!-- <button @click="editProject(project)">Edit</button> -->
                        <a href="">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<style scoped>
    .saleProjectsList{
        background-color: #fefeff;
        height: 100%;
    }
    input{
        height: 100%;
    }
    select{
        height: 35px;
    }
    .table{
        width: 100%;
        height: 80%;
    }
    table{
        margin-top: 3px;
        width: 100%;
        height: 100%;
    }
    th{
        /* outline: 1px solid #ccc; */
        text-align: left;
        font-weight: bold;
    }
    thead{
        padding: 5px;
        height: 10%;
    }
    tbody{
        height: 90%;
    }
    tbody tr{
        /* height: 10%; */
        /* padding-left: 5px; */
    }
    th:nth-child(1), td:nth-child(1){
        width: 12%;
    }
    th:nth-child(2), td:nth-child(2){
        width: 12%;
    }
    th:nth-child(3), td:nth-child(3){
        width: 12%;
    }
    th:nth-child(4), td:nth-child(4){
        width: 17%;
    }
    th:nth-child(5), td:nth-child(5){
        width: 27%;
    }
    th:nth-child(6), td:nth-child(6){
        width: 12%;
    }
    tr:nth-child(odd){
        background-color: #f0f5f8;
    }
    thead tr:nth-child(1){
        background-color: #fefeff;
    }
    .progress{
        display: flex;
    }
    .progress span{
        font-size: 12px;
        display: block;
        width: 30px;
        height: 17px;
        background-color: #BAE1F5;
        margin-right: 5px;
        text-align: center;
        line-height: 17px;
    }
    .progress span.active{
        background-color: #0096FF;
    }

</style>./ProjectListTable.vue