<script setup>
  import { defineProps, onBeforeMount, ref, watch } from 'vue';
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
  const hasInstaller = ref(false);
  const hasPictures = ref(false);
  const hasInformatoin = ref(false);
  const hasSolution = ref(false);

  const fetchData = () => {
    let url = '/api/v1/projects?houseId='+ props.houseId.toString();
    axios.get(url)
    .then((response) => {   
        data.value = response.data.data;
        houseCode.value = response.data.data[0].houseCode;
        hasInstaller.value = response.data.data[0].installer != null;
    })

    axios.get('/api/v1/pictures?houseId=' + props.houseId.toString() + '&type=H')
    .then((response) => {
      hasPictures.value = response.data.data.length > 0;
    })
    .catch((error)=>{
      console.log(error);
    });

    axios.get('/api/v1/pictures?houseId=' + props.houseId.toString() + '&type=D')
    .then((response) => {
      hasSolution.value = response.data.data.length > 0;
    })
    .catch((error) => {
      console.log(error);
    });

    axios.get('https://api.addwii.com/api/v1/management/houses/' + props.houseId.toString() + '/rooms', {
                headers: {
                    "Content-Type": 'application/json', 
                    "Accept": 'application/json',
                    'Authorization': `Bearer ${import.meta.env.VITE_API_AUTH_TOKEN}`
                }} 
    )
    .then((response) => {
      hasInformatoin.value = response.data.data.length;
    })
    .catch((error) => {
      console.log(error);
    })


  };

  onBeforeMount(() => {
    fetchData();
  });

  watch([addInstallerLightBoxDisplay, basicInfoLightBoxDisplay, uploadPictureLightBoxDisplay, uploadSolutionLightBoxDisplay], () => {
    fetchData();
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

  function handleUpdatePhotos(hasPhotosValue) {
    hasPictures.value = hasPhotosValue;
  }

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
            <button @click="toggleAddInstallerLightBox" :class="{ 'hasUploaded': hasInstaller }"> Add Installer </button>
            <AddInstallerLightBox v-if="addInstallerLightBoxDisplay" @closeAddInstallerForm="closeAddInstallerForm" :houseCode="houseCode"></AddInstallerLightBox>
            <button @click="toggleBasicInfoLightBox" :class="{ 'hasUploaded': hasInformatoin }"> Fill Out Basic Information</button>
            <BasicInfoLightBox v-if="basicInfoLightBoxDisplay" @closeBasicInfoLightBox="closeBasicInfoLightBox" :houseId="props.houseId" :houseCode="houseCode"></BasicInfoLightBox>
            <button @click="toggleUploadPictureLightBox" :class="{ 'hasUploaded': hasPictures }"> Upload Hand-Drawn Picture</button>
            <UploadPictureLightBox v-if="uploadPictureLightBoxDisplay" @closeUploadPictureLightBox="closeUploadPictureLightBox" :houseId="props.houseId" :houseCode="houseCode"></UploadPictureLightBox>
            <button @click="toggleUploadSolutionLightBox" :class="{ 'hasUploaded' : hasSolution }"> Upload Design Solution</button>
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
.hasUploaded{
  background-color: #a8cee0;
}
</style>
