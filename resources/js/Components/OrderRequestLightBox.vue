<script setup>
    import { defineEmits, defineProps, ref, onMounted } from 'vue'; 
    import closeIcon from '/public/icons/close.svg'

    const emits = defineEmits(['closeOrderRequestLightBox']);
    const props = defineProps({
        installer: String,
        user: String
    });
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
                    <style>
                    body { font-family: Arial, sans-serif; }
                    .order-request { max-width: 600px; margin: auto; padding: 20px; }
                    .order-request h2 { text-align: center; }
                    .order-request p { margin: 5px 0; }
                    img { max-width: 25%; height: auto; display: block; margin: auto; }
                    </style>
                </head>
                <body>
                    <div>
                        <img src="/images/ZAP_bg.png" alt="Order Image" onload="window.print(); window.close();">
                        <h2>Order Request</h2>
                        <p><b>Device Type:</b> ${deviceType.value}</p>
                        <p><b>Number of Devices Required:</b> ${numDevices.value}</p>
                        <p><b>Date Required:</b> ${dateRequired.value}</p>
                        <p><b>Sales:</b> ${sales.value}</p>
                        <p><b>Installer:</b> ${props.installer}</p>
                        <p><b>User:</b> ${props.user}</p>
                        <p><b>Notes:</b> ${notes.value}</p>
                    </div>
                </body>
            </html>
        `;
        printWindow.document.write(content);
        // printWindow.print();
        printWindow.document.close();
    };
</script>
<template>
    <div class="orderRequestLightBox">
        <div class="formInputs">
            <button class="closeBtn" @click="closeOrderRequestLightBox"><img :src=closeIcon alt=""></button>

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
    width: 26px;
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