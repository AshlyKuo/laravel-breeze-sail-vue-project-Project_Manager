<script setup>
  import { defineProps, onBeforeMount, ref } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import axios from 'axios';
  import AddInstallerLightBox from '@/Components/AddInstallerLightBox.vue';
  import BasicInfoLightBox from '@/Components/BasicInfoLightBox.vue';
  import UploadPictureLightBox from '@/Components/UploadPictureLightBox.vue';
  import UploadSolutionLightBox from '@/Components/UploadSolutionLightBox.vue';
  import BackBtn from '@/Components/BackToProgress.vue';
  import { Head } from '@inertiajs/vue3'


  const props = defineProps({
    houseId: String,
  });

  const addInstallerLightBoxDisplay = ref(false);
  const basicInfoLightBoxDisplay = ref(false);
  const uploadPictureLightBoxDisplay = ref(false);
  const uploadSolutionLightBoxDisplay = ref(false);
  const data = ref();
  const houseCode = ref();

  onBeforeMount(() => {
    let url = '/api/v1/projects?houseId='+ props.houseId.toString();
    axios.get(url)
    .then((response) => {   
        data.value = response.data.data;
        houseCode.value = response.data.data[0].houseCode;
    })
  });

  function toggleAddInstallerLightBox(){
    addInstallerLightBoxDisplay.value = true;
  };

  function toggleBasicInfoLightBox(){
    basicInfoLightBoxDisplay.value = true;
  };
  function toggleUploadPictureLightBox(){
    uploadPictureLightBoxDisplay.value = true;
  };
  function toggleUploadSolutionLightBox(){
    uploadSolutionLightBoxDisplay.value = true;
  };
  
  function closeAddInstallerForm(value){
    addInstallerLightBoxDisplay.value = value;
  };

  function closeBasicInfoLightBox(value){
    basicInfoLightBoxDisplay.value = value;
  };

  function closeUploadPictureLightBox(value){
    uploadPictureLightBoxDisplay.value = value;
  };
  function closeUploadSolutionLightBox(value){
    uploadSolutionLightBoxDisplay.value = value;
  };
  function doneProgressOne(){
    axios.patch('/api/v1/projects/'+ houseCode.value, {progress : 1})
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
        <Head title="Quotation" /> 
        <BackBtn :houseId="houseId"></BackBtn>
        <div class="wrapper">
            <button @click="toggleAddInstallerLightBox"> Add Installer </button>
            <AddInstallerLightBox v-if="addInstallerLightBoxDisplay" @closeAddInstallerForm="closeAddInstallerForm" :houseCode="houseCode"></AddInstallerLightBox>
            <button @click="toggleBasicInfoLightBox"> Fill Out Basic Information</button>
            <BasicInfoLightBox v-if="basicInfoLightBoxDisplay" @closeBasicInfoLightBox="closeBasicInfoLightBox" :houseId="props.houseId" :houseCode="houseCode"></BasicInfoLightBox>
            <button @click="toggleUploadPictureLightBox"> Upload Hand-Drawn Picture</button>
            <UploadPictureLightBox v-if="uploadPictureLightBoxDisplay" @closeUploadPictureLightBox="closeUploadPictureLightBox" :houseId="props.houseId" :houseCode="houseCode"></UploadPictureLightBox>
            <button @click="toggleUploadSolutionLightBox"> Upload Design Solution</button>
            <UploadSolutionLightBox v-if="uploadSolutionLightBoxDisplay" @closeUploadSolutionLightBox="closeUploadSolutionLightBox" :houseId="props.houseId" :houseCode="houseCode"></UploadSolutionLightBox>
            <button @click="doneProgressOne">ALL COMPLETE</button>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.wrapper{
    width: 70VW;
    height: 80vh;
    margin: 0 auto;
    margin-top: 5vh;
    /* outline: 1px solid #ccc; */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
}
button{
    width: 500px;
    height: 100px;
    line-height: 100px;
    background-color: #f0f5f8;
    border-radius: 10px;
    font-weight: bolder;
}
button:hover{
    background-color: #c8d5dc;
}
</style>
