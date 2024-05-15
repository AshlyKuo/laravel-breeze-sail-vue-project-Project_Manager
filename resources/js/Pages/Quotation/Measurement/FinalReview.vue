<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const pic = ref({

});

const savedRooms = ref([]);



</script>
<template>
    <AuthenticatedLayout>
    <div class="formContainer">
        <!-- 左側 -->
      <div class="savedRooms">
        <h2>Step 3: Final Review</h2>
        <!-- room 欄位 -->
        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>L</th>
                    <th>W</th>
                    <th>H</th>
                    <th>Outdoor PM2.5</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="info in savedRooms">
                    <th>info.</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
      </div>
      <!-- 右側 -->
      <div class="savedPictures">
        <div class="lists">
            <h2>Saved Pictures</h2>
            <ul>
            <li v-for="(savedPic, index) in savedPics" :key="savedPics.id">
                {{ index + 2 }}. {{ savedPics.name }}
                <button class="deleteBtn">-</button>
            </li>
            </ul>
        </div>
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
.savedPicss li{
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