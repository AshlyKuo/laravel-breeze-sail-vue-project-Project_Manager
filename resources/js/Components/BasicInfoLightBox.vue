<script setup>
    import { ref, defineEmits, defineProps, onMounted } from 'vue';
    import axios from 'axios';
    import editIcon from '/public/icons/edit.svg';
    import minusIcon from '/public/icons/minus.svg';
    import closeIcon from '/public/icons/close.svg'

    const emits = defineEmits(['closeBasicInfoLightBox']);
    const props = defineProps({
        houseId: String,
        houseCode: String
    });

    const room = ref({
        name: '',
        length: '',
        width: '',
        height: '',
        outdoorPm25: '',
        houseId: props.houseId,
        houseCode: props.houseCode,
        roomId: ''
    });

    const savedRooms = ref([]);

    const isEdit = ref(false);

    function toggleSaveBtn(id){
        isEdit.value = true;

        let url = '/api/v1/rooms/' + id;

        axios.get(url)
        .then(response => {
            console.log(response);
            room.value.roomId = response.data.data.roomId;
            room.value.name = response.data.data.name;
            room.value.length = response.data.data.length;
            room.value.width = response.data.data.width;
            room.value.height = response.data.data.height;
            room.value.outdoorPm25 = response.data.data.outdoorPm25;
        })
        .catch(error => {
            console.error(error);
        })

    }

    function editRoom(){
        console.log(room.value.roomId);
        let url = '/api/v1/rooms/' + room.value.roomId;

        axios.patch(url, {
            
            name : room.value.name,
            length : room.value.length,
            width : room.value.width,
            height : room.value.height,
            outdoorPm25 : room.value.outdoorPm25
            
        })
        .then(response => {
            console.log(response);
            room.value = { 
                name: '',
                length: '',
                width: '',
                height: '',
                outdoorPm25: '',
                houseId: props.houseId,
                houseCode: props.houseCode,
                roomId: '' 
            }; // reset form

            isEdit.value = false;
        })
        .catch(error => {
            console.error(error);
        })
    }

    onMounted(() => {
        getRooms();
    });
    // Get Rooms data
    async function getRooms(){
        try{
            let url = 'https://api.addwii.com/api/v1/management/houses/' + props.houseId + '/rooms';
            const response = await axios.get(url,{
                headers: {
                    "Content-Type": 'application/json', 
                    "Accept": 'application/json',
                    'Authorization': `Bearer ${import.meta.env.VITE_API_AUTH_TOKEN}`
                }
            })
            savedRooms.value = response.data.data;
        }catch(error){
            savedRooms.value = [];
        }
    };
    // Save Rooms
    async function saveRoom () {
        if(room.value.name && room.value.length && room.value.height && (room.value.outdoorPm25 || room.value.outdoorPm25 == 0)){
            try{
                let url = 'https://api.addwii.com/api/v1/management/houses/'+ props.houseId +'/rooms';
                const response =  await axios.post(url, {name: room.value.name}, {
                    headers: {
                        "Content-Type": 'application/json', 
                        "Accept": 'application/json',
                        'Authorization': `Bearer ${import.meta.env.VITE_API_AUTH_TOKEN}`
                    }
                });             
                room.value.roomId = response.data.data.id;
                if(response.data.data.id){
                    try{
                        const roomInfoResponse = axios.post('/api/v1/rooms', room.value);
                        getRooms();
                    }catch(error){
                        console.log(error.response);
                    }
                }
            }catch(error){
                console.log(error.response)
            }
            room.value = { 
                name: '',
                length: '',
                width: '',
                height: '',
                outdoorPm25: '',
                houseId: props.houseId,
                houseCode: props.houseCode,
                roomId: '' 
            }; // reset form
        }else{
            alert('Please Fill All Information');
        }        
    };
    // Delete Room
    async function deleteRoom ( roomId ){
        try{
            let url = 'https://api.addwii.com/api/v1/management/rooms/' + roomId;
            const response = await axios.delete( url, {
                headers: {
                    "Content-Type": 'application/json', 
                    "Accept": 'application/json',
                    'Authorization': `Bearer ${import.meta.env.VITE_API_AUTH_TOKEN}`
                } 
            });
            let deleteUrl = '/api/v1/rooms/' + roomId
            try{
                const deleteRoomResponse = axios.delete(deleteUrl);
            }catch(error){
                console.log(error.response);
            }
            getRooms();
        }catch(error){
            console.log(error.response);
        }
    }
    // Delete List
    function deleteList(id){
        deleteRoom(id);
    };
    // Close Light Box
    const closeBasicInfoLightBox = () => {
        emits('closeBasicInfoLightBox', false);
    };

</script>
<template>
    <div class="basicInfoLightBox">
        <div class="formContainer">
            <button class="closeBtn" @click="closeBasicInfoLightBox"><img :src=closeIcon alt=""></button>
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
                    <input type="number" id="pm25" v-model.number="room.outdoorPm25" placeholder="µg/m3" min="0">
                </div>        
                <button @click="saveRoom" class="saveBtn" type="button" v-if="isEdit == false">Save</button>
                <button @click="editRoom" class="saveBtn" type="button" v-if="isEdit == true">Save Change</button>
            </div> 
      
            <div class="savedRooms">
                <div class="lists">
                    <h2>Saved rooms</h2>
                    <ul>
                    <li v-for="(savedRoom, index, ) in savedRooms" :key="savedRoom.id">
                        {{ index + 1 }}. {{ savedRoom.name }}
                        <button class="deleteBtn" @click="deleteList( savedRoom.id )"><img :src=minusIcon alt="delete"></button>
                        <button class="editBtn" @click="toggleSaveBtn( savedRoom.id )"><img :src=editIcon alt="edit"></button>
                    </li>
                    </ul>
                </div>
                <button class="doneBtn" @click="closeBasicInfoLightBox">Done</button>
            </div>
        </div>
    </div>

</template>
<style scoped>
.basicInfoLightBox{
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

.formContainer{
    background-color: #fff;
    width: 80vw;
    height: 90Vh;
    padding: 30px;
    border-radius: 10px;
    display: flex;
    flex-direction: row;
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
    width: 18px;
    position: absolute;
    right:25px;
}
.editBtn{
    position: absolute;
    right:60px;
    width: 20px;
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