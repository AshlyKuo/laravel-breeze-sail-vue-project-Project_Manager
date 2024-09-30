<script setup>
    import { ref, defineEmits, defineProps, onMounted } from 'vue';
    import axios from 'axios';
    import closeIcon from '/public/icons/close.svg'
    import minusIcon from '/public/icons/minus.svg';

    const emits = defineEmits(['closeUploadSolutionLightBox']);
    const props = defineProps({
        houseId: String,
        houseCode: String
    });

    const pic = ref({
        name: '',
        url: '',
        houseId: props.houseId,
        houseCode: props.houseCode,
        type: 'D'
    });
    const savedPics = ref([]);
    const image = ref(null);
    const fileInput = ref(null);

    function handleFileUpload(event) {
        // console.log(event.target.files[0]);
        image.value = event.target.files[0];
    };

    async function uploadPhoto() {
    try {
        const checkResponse = await axios.get('/api/v1/pictures?name=' + pic.value.name + '&houseId=' + pic.value.houseId+ '&type=D');
        if (checkResponse.data.data.length) { 
            alert("Picture name has existed. Please rename this picture.");
            return; 
        }

        const formData = new FormData();
        formData.append('image', image.value);

        const uploadResponse = await axios.post('/uploadPicture', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
        // console.log(uploadResponse);
        pic.value.url = 'https://s3.ap-northeast-1.amazonaws.com/s3.zap/' + uploadResponse.data.path;

        const saveResponse = await axios.post('/api/v1/pictures', pic.value);
        // console.log(saveResponse);

        getPhotos();

        pic.value = {
            name: '',
            url: '',
            houseId: props.houseId,
            houseCode: props.houseCode,
            type: 'D'
        };

        if (fileInput.value) {
            fileInput.value.value = '';
        }
        image.value = null;

    } catch (error) {
        console.error(error);
    }
    };

    onMounted(() => {
        getPhotos();
    });

    async function getPhotos(){
        let url = '/api/v1/pictures?houseId=' + props.houseId + '&type=D';
        try{
            const response = await axios.get(url);
            savedPics.value = response.data.data;
        }catch(error){
            console.log(error.response);
        }
    };

    const closeUploadSolutionLightBox = () => {
        emits('closeUploadSolutionLightBox', false);
    };

    async function deleteList(url, id){
        try{
            // console.log(id, url);
            const deleteResponse = await axios.delete('/api/v1/pictures/' + id);
            if(deleteResponse.status == 200){
                try{
                    
                    const parsedUrl = new URL(url);
                    const path = parsedUrl.pathname;
                    const prefix = '/s3.zap/';
                    const trimmedPath = path.replace(prefix, '');
                    const data = { path : trimmedPath};

                    const removeResponse = await axios.post('/deletePicture', data);
                    getPhotos();
                }catch(error){
                    console.log(error);
                }
            }
        }catch(error){
            console.log(error);
        }

    }


</script>
<template>
    <div class="uploadSolutionLightBox">
        <div class="formContainer">
            <button class="closeBtn" @click="closeUploadSolutionLightBox"><img :src=closeIcon alt=""></button>
            <!-- 左側 -->
            <div class="formInputs">
                <h2>Upload design solution</h2>
                <!-- room 欄位 -->
                <div class="fileNameRow">
                    <label for="fileName">1. File Name:</label>
                    <input type="text" id="fileName" v-model="pic.name" required>            
                </div>
                <!-- 照片上傳欄位 -->
                <div class="fileUploadRow">
                    <h3>2. Upload:</h3>
                    <div class="customFileUpload">
                        <!-- <label for="fileUpload" >
                            <div class="iconPlus">+</div>
                            Upload Photo
                        </label> -->
                        <input id="fileUpload" type="file" accept="image/*" @change="handleFileUpload" ref="fileInput" />
                    </div>   
                </div>
                <button @click="uploadPhoto" class="saveBtn">Save</button>
            </div>
            <!-- 右側 -->
            <div class="savedPictures">
                <div class="lists">
                    <h2>Saved Pictures</h2>
                    <ul>
                    <li v-for="(savedPic, index) in savedPics" :key="savedPic.id">
                        {{ index + 1 }}.<img :src=savedPic.url>{{ savedPic.name }}
                        <button class="deleteBtn" @click="deleteList(savedPic.url, savedPic.id)"><img :src=minusIcon alt="delete"></button>
                    </li>
                    </ul>
                </div>
                <button class="doneBtn" @click="closeUploadSolutionLightBox">Done</button>
            </div>
        </div>
    </div>
</template>
<style scoped>
.uploadSolutionLightBox{
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
.formContainer {
  display: flex;
  width: 80vw;
  margin: 10vh auto;
  height: 80vh;
  background-color: #fff;
  padding: 30px;
  border-radius: 10px;
  position: relative;
}
.closeBtn{
    position: absolute;
    right: 15px;
    top: 10px;
    width: 26px;
}

.formInputs{
    width: 55%;
    height: 100%;
    /* outline: 1px solid #ccc; */
    margin-right: 40px;
    position: relative;
}
.formInputs h2{
    margin-bottom: 20px;
}
label{
    margin-right: 5px;
    font-weight: bold;
}
input{
    background-color: #f0f5f8;
    border: none;
    border-radius: 4px;
    height: 35%;
}
input[type="text"],
input[type="number"] {
  display: block;
}
.fileNameRow{
    display: flex;
    align-items: center;
    margin-bottom: 5%;
}
.fileNameRow input{
    width: 80%;
}
.fileUploadRow{
    height: 70%;
    flex: none;
}
.fileUploadRow h3{
    font-weight: bold;
    margin-bottom: 30px;
}
.customFileUpload{
    border: 3px solid #f0f5f8;
    border-radius: 5px;
    width: 100%;
    height: 70%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.fileUploadRow label{
    width: 50%;
    height: 50%;
    cursor: pointer;
    /* outline: 1px solid salmon; */
    text-align: center;
}
.iconPlus{
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background-color: #f0f5f8;
    font-size: 70px;
    line-height: 70px;
    margin-bottom: 5px;
    font-weight: lighter;
}
.saveBtn{
    background-color: #f0f5f8;
    width: 200px;
    height: 30px;
    border-radius: 5px;
    width: 100%;
    position: absolute;
    bottom: 10px;
}

.savedPictures{
    width: 45%; 
    height: 100%;   
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    /* outline: 1px solid #ccc; */
}
.savedPictures h2{
    border-bottom: 3px solid white;
    height: 40px;
    line-height: 40px;
    padding-left: 20px;
    font-weight: bold;
}
ul {
  list-style: none;
  padding: 0;
}
.savedPictures li{
    border-bottom: 3px solid white;
    padding-left: 20px;
    height: 90px;
    line-height: 90px;
    display: flex;
    align-items: center;
    position: relative;
}
.savedPictures li img{
    height: 40px;
    margin: 0 20px;
    /* outline: 1px solid #ccc; */
}
.lists{
    width: 80%;
    height: 85%;
    margin-bottom: 10%;
    background-color: #f0f5f8;
    border-radius: 5px;
}
.lists ul{
    overflow-y: auto;
    height: 90%;
}
.deleteBtn{
    width: 18px;
    position: absolute;
    right:45px;
}
.doneBtn{
    color: white;
    font-weight: bold;
    background-color: #0096ff;
    height: 30px;
    width: 80%;
    border-radius: 3px;
    position: absolute;
    bottom: 10px;
}

</style>