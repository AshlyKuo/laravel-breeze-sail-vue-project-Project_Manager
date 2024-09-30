<script setup>
    import { defineEmits, ref } from 'vue';
    import axios from 'axios';
    import closeIcon from '/public/icons/close.svg'

    const emits = defineEmits(['closeForm']);
    const closeForm = () => {
        emits('closeForm', false);
    };

    const form = ref({
        client : '',
        phone: '',
        email: '',
        date: '',
        address: '',
        sales: '',
        houseCode: '',
        houseId: '',
        notes: '',
        amounts: '',
        currency: ''
    });

    async function submitForm() {
        try {
            const houseResponse = await axios.post('https://api.addwii.com/api/v1/management/houses', {}, {
                headers: {
                    "Content-Type": 'application/json', 
                    "Accept": 'application/json',
                    'Authorization': `Bearer ${import.meta.env.VITE_API_AUTH_TOKEN}`
                }
            });
            if(houseResponse.data.data.house_code){
                form.value.houseCode = houseResponse.data.data.house_code;
                form.value.houseId = houseResponse.data.data.id;
                try{
                    const projectResponse = await axios.post('/api/v1/projects', form.value);
                    emits('closeForm', false);
                }catch(error){
                    console.log('Error creating project QQ:', error.response);
                }
            }
        } catch (error) {
            console.log('Error creating project:', error.response);

        }
    };


</script>
<template>
    <div class="newProjectLightBox">
        <div class="form"> 
            <button class="closeBtn" @click="closeForm"><img :src=closeIcon alt=""></button>
            <h2>New Project</h2>
            <form action="">
                <div>
                    <p>
                        <label for="customerName"><span style="color: #0096FF;">*</span>Customer Name:</label>
                        <input type="text" id="customerName" v-model="form.client" required>
                    </p>
                    <p>
                        <label for="phone"><span style="color: #0096FF;">*</span>Phone:</label>
                        <input type="text" id="phone" v-model="form.phone" required>
                    </p>
                </div>
                <div>
                    <p>
                        <label for="email"><span style="color: #0096FF;">*</span>Email:</label>
                        <input type="email" id="email" v-model="form.email" required>
                    </p>
                    <p>
                        <label for="startDate"><span style="color: #0096FF;">*</span>Start Date:</label>
                        <input type="date" id="startDate" v-model="form.date" required>
                    </p>
                </div>
                <div>
                    <p>
                        <label for="address"><span style="color: #0096FF;">*</span>Address:</label>
                        <input type="text" id="address" v-model="form.address" required>
                    </p>
                    <p>
                        <label for="assignedTo"><span style="color: #0096FF;">*</span>Assigned To:</label>
                        <input type="text" id="assignedTo" v-model="form.sales" required>
                    </p>
                </div>
                <div>
                    <p class="amounts"> 
                        <label for="amounts">Amount:</label>
                        <div class="amountsInput">
                            <input type="number" id="amounts" v-model="form.amounts">
                            <select name="currency" id="currency" v-model="form.currency">
                                <option value="NTD">NTD</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </p>
                    <p class="notes"> 
                        <label for="notes">Notes:</label>
                        <input type="text" id="notes" v-model="form.notes">
                    </p>
                </div>
                <div>
                    <button class="sendBtn" @click="submitForm" type="button">Add New Project</button>
                </div>
            </form>
        </div>
    </div>
</template>
<style scoped>
    .newProjectLightBox{
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
        position: relative;
        width: 80%;
        height: 80%;
        background-color: white;
        padding: 30px;
        border-radius: 10px;
    }
    h2{
        font-weight: bold;
        font-size: larger;
        height: 10%;
    }
    .closeBtn{
        position: absolute;
        right: 15px;
        top: 10px;
        width: 26px;
    }
    form{
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 90%;
    }
    form div{
        display: flex;
        width: 100%;
        justify-content: space-around;
        margin-top: 5px;
    }
    form div p{
        display: flex;
        flex-direction: column;
        width: 45%;
        margin-bottom: 3%;
    }
    form div p.notes{
        margin-bottom: 2%;
    }
    input{
        background-color: #f0f5f8;
        border: none;
        border-radius: 5px;
    }
    .amountsInput input{
        width: 70%;
    }
    .amountsInput select{
        border: none;
        background-color: #f0f5f8;
        width: 30%;
    }
    .sendBtn{
        background-color: #0096ff;
        color: white;
        font-weight: bolder;
        width: 400px;
        height: 50px;
        position: absolute;
        bottom: 25px;
        border-radius: 5px;
    }
</style>