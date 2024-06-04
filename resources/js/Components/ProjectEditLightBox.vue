<script setup>
import { defineEmits, defineProps, onMounted, ref } from 'vue';
import axios from 'axios';
import closeIcon from '/public/icons/close.svg'

const emits = defineEmits(['closeForm']);
const props = defineProps({
    houseCode: String,
});
const closeForm = () => {
    emits('closeForm', false);
};

const form = ref({
    date: '',
    client: '',
    phone: '',
    email: '',
    sales: '',
    installer: '',
    address: '',
    amounts: '',
    currency: '',
    notes: ''
});

onMounted(() => {
    getInfo();
});

async function getInfo(){
    try{
        const response = await axios.get('/api/v1/projects/' + props.houseCode);
        form.value.date = response.data.data.date;
        form.value.client = response.data.data.client;
        form.value.phone = response.data.data.phone;
        form.value.email = response.data.data.email;
        form.value.sales = response.data.data.sales;
        form.value.installer = response.data.data.installer;
        form.value.address = response.data.data.address;
        form.value.amounts = response.data.data.amounts;
        form.value.currency = response.data.data.currency;
        form.value.notes = response.data.data.notes;
    }catch(error){

    }
}

function editProject(){
    axios.patch('/api/v1/projects/'+ props.houseCode, form.value)
    .then(response => {
        console.log(response);
        emits('closeForm', false);

    })
    .catch(error => {
        console.error(error);
    });
};


</script>

<template>
    <div class="addUserWrapper"> 
        <div class="form">
            <button class="closeBtn" @click="closeForm"><img :src=closeIcon alt=""></button>
            <form action="" class="flex flex-col">
                <div>
                    <p>
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" v-model="form.date">
                    </p>
                    <p>
                        <label for="client">Client</label>
                        <input type="text" name="client" id="client" v-model="form.client">
                    </p>
                    
                </div>
                <div>
                    <p>
                        <label for="sales">Sales</label>
                        <input type="text" name="sales" id="sales" v-model="form.sales">
                    </p>
                    <p>
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" v-model="form.phone">
                    </p>
                </div>
                <div>
                    <p>
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" v-model="form.address">
                    </p>
                    <p>
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email" v-model="form.email">
                    </p>
                </div>
                <div>
                    <p>
                        <label for="amounts">Amounts</label>
                        <input type="number" name="amounts" id="amounts" v-model="form.amounts">
                    </p>
                    <p>
                        <label for="currency">Currency</label>
                        <select v-model="form.currency">
                            <option value="NTD">NTD</option>
                            <option value="USD">USD</option>
                        </select>
                    </p>
                </div>
                <label for="notes">Notes</label>
                <input type="text" name="notes" id="notes" v-model="form.notes">

                <button @click="editProject" type="button" class="editBtn">Edit Project</button>
            </form>
        </div>
    </div>

</template>
<style scoped> 
.addUserWrapper{
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
    height: 70%;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
}
.closeBtn{
    position: absolute;
    right: 15px;
    top: 10px;
    width: 26px;
    background-color: none;
}

.form div{
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}
.form div p{
    display: flex;
    flex-direction: column;
    width: 45%;
}

input{
    border: none;
    background-color: #f0f5f8;
    border-radius: 5px;
    width: 100%;
}
select{
    border: none;
    background-color: #f0f5f8;
    border-radius: 5px;
}
.editBtn{
    background-color: #0096fe;
    color: white;
    width: 40%;
    margin: 0 auto;
    margin-top: 20px;
    height: 40px;
    border-radius: 5px;
    font-weight: 600;
}
</style>