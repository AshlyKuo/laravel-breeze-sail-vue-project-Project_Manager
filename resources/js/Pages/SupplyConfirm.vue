<script setup>
    import { defineProps, onMounted, ref, reactive, computed, watch, watchEffect } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import supplyIcon from '/public/icons/supply.svg';
    import supplyCheckIcon from '/public/icons/supplyCheck.svg';
    import axios from 'axios';
    import { Head } from '@inertiajs/vue3'

    const props = defineProps({
        houseId: String,
    });

    const requiredNum = reactive({
        zs2 : '',
        ffu : '',
        zef : '',
        zrh : ''
    });

    const houseCode = ref();

    function goToSupplyCheck(houseId){
        location.assign(`/project/${houseId}/supply`);
    };

    onMounted(() => {
        getRequire();
    });
    async function getRequire(){
        try{
            const response = await axios.get('/api/v1/projects?houseId=' + props.houseId);
            requiredNum.zs2 = response.data.data[0].zs2;
            requiredNum.ffu = response.data.data[0].ffu;
            requiredNum.zef = response.data.data[0].zef;
            requiredNum.zrh = response.data.data[0].zrh;
            houseCode.value = response.data.data[0].houseCode;
            // console.log(response);
        }catch(error){
            console.error(error);
        }
    };

    function supplyConfirm(){
        axios.patch('/api/v1/projects/'+ houseCode.value, {progress : 3})
        .then(() => {
            location.assign(`/project/${props.houseId}/progress`);
        })
        .catch(error => {
            console.error('Failed to update status:', error);
        });
    };


</script>
<template>
    <AuthenticatedLayout>
        <Head title="Supply" />
        <a class="backBtn" @click="goToSupplyCheck(houseId)"> < Last Step</a>
        <div class="supplyConfirm">
            <h2><img :src="supplyIcon">Confirmation of Device shipment</h2>
            <h3>Please confirm the number of devices selected and ensure quality inspection before shipment</h3>
            <div class="imgDiv">
                <span>Selected devices :</span>
                <span>ZS2:{{ requiredNum.zs2 }}</span>
                <span>FFU:{{ requiredNum.ffu }} </span>
                <span>ZEF:{{ requiredNum.zef }}</span>
                <span>ZRH:{{ requiredNum.zrh }}</span>
                <!-- <img :src="supplyCheckIcon"> -->
            </div>
            <button @click="supplyConfirm">Confirm</button>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.supplyConfirm{
    width: 70vw;
    height: 80vh;
    margin: 0 auto;
    margin-top: 6vh;
    font-weight: 600;
}
.backBtn{
    position: absolute;
    top: 60px;
    left: 25px;
    font-size: 15px;
    width: 300px;
    height: 40px;
    /* outline: 1px solid; */
}
.backBtn:hover{
    cursor: pointer;
    text-decoration: underline;
}
h2{
    margin-bottom: 20px;
    padding-left: 10px;
    display: flex;
    align-items: center;
}
h2 img{
    padding-right: 5px;
}
h3{
    margin-bottom: 10px;
    padding-left: 10px;
    font-size: 17px;
}
span{
    color: #0096ff;
    padding-left: 10px;
    font-size: 20px;
}
.imgDiv{
    width: 99%;
    /* margin: 20px auto; */
    padding-left: 30px;
    height: 40vh;
    background-color: #f0f5f8;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: space-around;
    margin-bottom: 30px;
}
button{
    background-color: #0096ff;
    color: white;
    width: 300px;
    height: 50px;
    border-radius: 5px;
    margin-left: calc((100% - 300px) / 2);
}
</style>