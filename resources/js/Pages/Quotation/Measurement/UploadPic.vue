<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const pic = ref({
  name: '',
  url: '',
  roomId: '',
  houseId: '',
  houseCode: '',

});

const savedPics = ref([]);

const submitPhoto = () => {
  savedPics.value.push({ ...pic.value, id: savedPics.value.length + 1 });
  pic.value = { name: '', }; // reset form
};

const deleteList = (index) => {
    savedPics.value.splice(index, 1);
};
</script>
<template>
    <AuthenticatedLayout>
    <div class="formContainer">
        <!-- 左側 -->
      <div class="formInputs">
        <h2>Step 2: Upload a hand-drawn picture</h2>
        <!-- room 欄位 -->
        <div class="fileNameRow">
            <label for="fileName">1. File Name:</label>
            <input type="text" id="fileName" v-model="pic.name" required>            
        </div>
        <!-- 照片上傳欄位 -->
        <div class="fileUploadRow">
            <h3>2. Upload:</h3>
            <div class="customFileUpload">
                <label for="fileUpload" >
                    <div class="iconPlus">+</div>
                    Upload Photo
                </label>
                <input id="fileUpload" type="file" accept="image/*, .pdf" @change="handleFileChange" style="display: none;"/>
            </div>   
        </div>
        <button @click="submitPhoto" class="saveBtn">Save</button>
      </div>
      <!-- 右側 -->
      <div class="savedPictures">
        <div class="lists">
            <h2>Saved Pictures</h2>
            <ul>
            <li v-for="(savedPic, index) in savedPics" :key="savedPics.id">
                {{ index + 1 }}. {{ savedPic.name }}
                <button class="deleteBtn" @click="deleteList(index)">-</button>
            </li>
            </ul>
        </div>
        <button class="nextBtn">Next</button>
      </div>
    </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.formContainer {
  display: flex;
  width: 80vw;
  margin: 10vh auto;
  height: 70vh;
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
    outline: 3px solid #f0f5f8;
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
    height: 40px;
    line-height: 40px;
    display: flex;
    align-items: center;
    position: relative;
}
.lists{
    width: 80%;
    height: 85%;
    margin-bottom: 10%;
    background-color: #f0f5f8;
    border-radius: 5px;
    overflow-y: auto;
}
.deleteBtn{
    display: block;
    font-size: 30px ;
    line-height: 20px;
    border-radius: 50%;
    height: 20px;
    width: 20px;
    outline: 2px solid black;
    position: absolute;
    right:30px;
}
.nextBtn{
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