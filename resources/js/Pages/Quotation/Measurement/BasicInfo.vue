<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const room = ref({
  name: '',
  length: '',
  width: '',
  height: '',
  pm25: '',
  houseID: '',
  houseCode: '',
  roomId: ''
});

const savedRooms = ref([]);

const saveRoom = () => {
  savedRooms.value.push({ ...room.value, id: savedRooms.value.length + 1 });
  room.value = { name: '', length: '', width: '', height: '', pm25: '' }; // reset form
};

const deleteList = (index) => {
    savedRooms.value.splice(index, 1);
};
</script>
<template>
    <AuthenticatedLayout>
    <div class="formContainer">
      <div class="formInputs">
        <h2>Fill out basic information</h2>
        <div class="roomRow">
            <label for="roomName">1. Room Name:</label>
            <input type="text" id="roomName" v-model="room.name" required>
        </div>
        <div class="sizeRow">
            <label for="size">2. Size of Room<br> (L x W x H):</label>
            <input type="number" id="length" v-model.number="room.length" placeholder="ft" min="1" required>
            <input type="number" id="width" v-model.number="room.width" placeholder="ft" min="1" required>
            <input type="number" id="height" v-model.number="room.height" placeholder="ft" min="1" required>
        </div>
        <div class="lastRow">
            <label for="pm25">3. Outdoor Annual<br> Average PM2.5:</label>
            <input type="number" id="pm25" v-model.number="room.pm25" placeholder="µg/m3" min="0">
        </div>        
        <button @click="saveRoom" class="saveBtn" type="button">Save</button>
      </div>
      
      <div class="savedRooms">
        <div class="lists">
            <h2>Saved rooms</h2>
            <ul>
            <li v-for="(savedRoom, index) in savedRooms" :key="savedRoom.id">
                {{ index + 1 }}. {{ savedRoom.name }}
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
.formInputs div{
    width: 100%;
    display: flex;
    height: 25%;
    align-items: center;
}
label{
    margin-right: 5px;
    font-weight: bold;
    width: 200px;
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
.roomRow input{
    width: calc(100% - 200px);
}
.sizeRow input{
    width: calc((100% - 200px)/4);
    margin-right: 5%;
    
}
.lastRow{

}

ul {
  list-style: none;
  padding: 0;
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
.savedRooms{
    width: 45%; 
    height: 100%;   
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    /* outline: 1px solid #ccc; */
}
.savedRooms h2{
    border-bottom: 3px solid white;
    height: 40px;
    line-height: 40px;
    padding-left: 20px;
    font-weight: bold;
}
.savedRooms li{
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