<script setup>
    import { defineEmits, defineProps, ref } from 'vue'; 

    const emits = defineEmits(['closeOrderRequestLightBox']);
    const deviceType = ref('');
    const numDevices = ref(0);
    const dateRequired = ref('');
    const notes = ref('');
    const sales = ref('');


    const closeOrderRequestLightBox = () => {
        emits('closeOrderRequestLightBox', false);
    };

    function printRequest(){
        const printWindow = window.open('', '_blank');
        const content = `
            <html>
                <head>
                    <title>Order Request</title>
                    <style>
                    </style>
                </head>
                <body>
                    <h2>Order Request</h2>
                    <p>Device Type: ${deviceType.value}</p>
                    <p>Number of Devices Required: ${numDevices.value}</p>
                    <p>Date Required: ${dateRequired.value}</p>
                    <p>Sales: ${sales.value}
                    <p>Notes: ${notes.value}</p>
                </body>
            </html>
        `;
        printWindow.document.write(content);
        printWindow.print();
        printWindow.document.close();
    };
</script>
<template>
    <div class="orderRequestLightBox">
        <div class="formInputs">
            <button class="closeBtn" @click="closeOrderRequestLightBox">X</button>

            <h2>Order Request</h2>
            <form action="">
                <label for="">Which type of device:</label>
                <input type="text" v-model="deviceType">

                <label for="">Number of devics required</label>
                <input type="number" v-model="numDevices">

                <label for="">Date required</label>
                <input type="date" v-model="dateRequired">

                <label for="">Sales</label>
                <input type="text" v-model="sales">

                <label for="">Notes</label>
                <input type="text" v-model="notes">

                <button type="button" class="sendBtn" @click="printRequest">Send</button>
            </form>
        </div>
    </div>
</template>
<style scoped>
.orderRequestLightBox{
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
.formInputs{
    display: flex;
    flex-direction: column;
    width: 40vw;
    margin: 10vh auto;
    height: 600px;
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    position: relative;
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
h2{
    padding-bottom: 10px;
}
form{
    display: flex;
    flex-direction: column;
}
input{
    border: none;
    background-color: #f0f5f8;
    margin-bottom: 18px;
    border-radius: 5px;
}
.sendBtn{
    width: 300px;
    height: 40px;
    border-radius: 5px;
    background-color: #0096ff;
    color: white;
    margin: 0 auto;
    margin-top: 20px;
}
</style>