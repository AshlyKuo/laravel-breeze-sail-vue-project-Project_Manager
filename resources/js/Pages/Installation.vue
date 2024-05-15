<script setup>
    import { defineProps, ref, onMounted } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import BackBtn from '@/Components/BackToProgress.vue';
    import axios from 'axios';
    import { Head } from '@inertiajs/vue3'

    const props = defineProps({
        houseId: String,
    });

    const houseCode = ref();

    onMounted(() => {
        getInfo()
    });

    async function getInfo(){
        try{
            const response = await axios.get('/api/v1/projects?houseId=' + props.houseId);
            houseCode.value = response.data.data[0].houseCode;
        }catch(error){}
    };

    function installationConfirm(){
        axios.patch('/api/v1/projects/'+ houseCode.value, {progress : 4})
        .then(() => {
            location.assign(`/project/${props.houseId}/progress`);
        })
        .catch(error => {
            console.error('Failed to update status:', error);
        });
    };



</script>
<template>
    <AuthenticatedLayout>
        <Head title="Installation" />
        <BackBtn :houseId="houseId"></BackBtn>
        <div class="installation">
            <h2>Confirm all device be installed</h2>
            <button @click="installationConfirm">Confirm</button>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.installation{
    width: 70VW;
    margin: 20vh auto;
    height: 40vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}
h2{
    font-size: 30px;
    font-weight: 600;
}
button{
    width: 300px;
    height: 40px;
    border-radius: 5px;
    font-weight: 600;
    background-color: #0096ff;
    color: white;
    margin-top: 40px;
}
</style>