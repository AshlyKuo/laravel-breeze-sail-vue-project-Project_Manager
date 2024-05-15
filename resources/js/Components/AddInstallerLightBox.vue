<script setup> 
    import { defineEmits, ref, defineProps, onMounted } from 'vue';
    import axios from 'axios';

    const emits = defineEmits(['closeAddInstallerForm']);
    const props = defineProps({
        houseCode: String
    });
    const closeAddInstallerForm = () => {
        emits('closeAddInstallerForm', false);
    };
    const form = ref({
        installer : '',
    });

    async function submitForm(){
        try{
            let url = '/api/v1/projects/' + props.houseCode; 
            const response = await axios.patch(url, form.value);
            emits('closeAddInstallerForm', false);
        }catch(error){
            console.log(error.response);
        }
    };

    onMounted(() => {
        axios.get('/api/v1/projects/' + props.houseCode)
        .then((response)=>{
            form.value.installer = response.data.data.installer;
        })
        .catch(()=>{
            console.log(error);
        })
    })

</script>
<template>
    <div class="addInstallerLightBox">
        <div class="form">
            <button class="closeBtn" @click="closeAddInstallerForm">X</button>
            <h2>Installer</h2>
            <form action="">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" v-model="form.installer" required>
                </div>
                <button type="button" @click="submitForm" class="addBtn">Add</button>
            </form>
        </div>
    </div>

</template>
<style scoped>
.addInstallerLightBox{
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
.form{
    background-color: #fff;
    width: 400px;
    height: 300px;
    position: relative;
    border-radius: 5px;
}
.form h2{
    padding-left: 20px;
    padding-top: 10px;
    font-weight: bold;
    font-size: 20px;
}
.closeBtn{
    position: absolute;
    right: 15px;
    top: 10px;
    border: 1.5px solid black;
    border-radius: 50%;
    width: 23px;
    height: 23px;
    line-height: 21.5px;
    font-size: 15px;
}
form{
    height: 70%;
    padding-top: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}
form div{
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}
form label{
    width: 80%;
    text-align: left;
}
form input{
    background-color: #f0f5f8;
    border: none;
    width: 80%;
    border-radius: 5px;
}
.addBtn{
    background-color: #0096ff;
    color: #fff;
    font-weight: bold;
    width: 75%;
    height: 15%;
    border-radius: 5px;
}
</style>