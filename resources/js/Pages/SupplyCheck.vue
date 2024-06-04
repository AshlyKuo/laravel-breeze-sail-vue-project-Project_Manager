<script setup>
  import { defineProps, onMounted, ref, reactive, computed, watch, watchEffect } from 'vue';
  import axios from 'axios';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import supplyIcon from '/public/icons/supply.svg';
  import OrderRequestLightBox from '@/Components/OrderRequestLightBox.vue';
  import BackBtn from '@/Components/BackToProgress.vue';
  import { Head } from '@inertiajs/vue3'

  const props = defineProps({
    houseId: String,
  });
  const confirmBtnDisabled = ref(true);
  const orderRequestLightBoxDisplay = ref(false);

  const zs2InStockNum = ref();
  const ffuInStockNum = ref();
  const zefInStockNum = ref();
  const zrhInStockNum = ref();
  const installer = ref();

  const requiredNum = reactive({
    zs2 : Number,
    ffu : Number,
    zef : Number,
    zrh : Number
  });

  const houseCode = ref();

  onMounted(() => {
    const url = '/api/v1/projects?houseId='+ props.houseId;
    axios.get(url)
    .then((response) => {   
        houseCode.value = response.data.data[0].houseCode;            
    });
    getStock();
    getRequire();
  });

  async function getStock(){
    try{
        const response = await axios.get('/api/v1/stock');
        zs2InStockNum.value = response.data.data[0].number;
        ffuInStockNum.value = response.data.data[1].number;
        zefInStockNum.value = response.data.data[2].number;
        zrhInStockNum.value = response.data.data[3].number;
    }catch(error){
        console.error(error);
    }
  };

  async function getRequire(){
    try{
        const response = await axios.get('/api/v1/projects?houseId=' + props.houseId);
        requiredNum.zs2 = response.data.data[0].zs2;
        requiredNum.ffu = response.data.data[0].ffu;
        requiredNum.zef = response.data.data[0].zef;
        requiredNum.zrh = response.data.data[0].zrh;
        installer.value = response.data.data[0].installer;
    }catch(error){
        console.error(error);
    }
  };

  function toggleOrderRequestLightBox(){
    orderRequestLightBoxDisplay.value = true;
  };

  function closeOrderRequestLightBox(value){
    orderRequestLightBoxDisplay.value = value;
  };

  function goToSupplyDoubleCheck(houseId){
    try{
        const response = axios.patch('/api/v1/projects/' + houseCode.value, requiredNum);
        location.assign(`/project/${houseId}/supply_confirm`);
    }catch(error){
        console.error(error);
    }

  };

  const allInput = computed(() => {
    return (requiredNum.zs2 >= 0 && requiredNum.zs2 != null) && (requiredNum.ffu >= 0 && requiredNum.ffu != null) && (requiredNum.zef >= 0 && requiredNum.zef != null) && (requiredNum.zrh >= 0 && requiredNum.zrh != null);
  });
  
  const numEnough = computed(() => {
    return (requiredNum.zs2 - zs2InStockNum.value <= 0) && (requiredNum.ffu - ffuInStockNum.value <= 0) && (requiredNum.zef - zefInStockNum.value <= 0) && (requiredNum.zrh - zrhInStockNum.value <= 0);
  });
  
  watchEffect(() => {
    confirmBtnDisabled.value = !(allInput.value && numEnough.value);
  });



</script>
<template>
    <AuthenticatedLayout>
        <Head title="Supply" />
        <BackBtn :houseId="houseId"></BackBtn>
        <div class="supplyCheck">
            <h2><img :src="supplyIcon">Select Available Devices</h2>
            <div class="numCheck">
                <ul>
                    <li>
                        <span>Available ZS2 : <span class="inStockNum">{{ zs2InStockNum }}</span></span>
                        <span v-if="requiredNum.zs2 - zs2InStockNum > 0" class="numWarn">* <span>{{ requiredNum.zs2 - zs2InStockNum }}</span> more device required</span>
                        <input type="number" min="0" v-model="requiredNum.zs2" placeholder="Require ZS2">
                    </li>
                    <li>
                        <span>Available FFU : <span class="inStockNum" >{{ ffuInStockNum }}</span></span>
                        <span v-if="requiredNum.ffu - ffuInStockNum > 0" class="numWarn">* <span>{{ requiredNum.ffu - ffuInStockNum }}</span> more device required</span>
                        <input type="number" min="0" v-model="requiredNum.ffu" placeholder="Require FFU">
                    </li>
                    <li>
                        <span>Available ZEF : <span class="inStockNum">{{ zefInStockNum }}</span></span>
                        <span v-if="requiredNum.zef - zefInStockNum > 0" class="numWarn">* <span>{{ requiredNum.zef - zefInStockNum }}</span> more device required</span>
                        <input type="number" min="0" v-model="requiredNum.zef" placeholder="Require ZEF">
                    </li>
                    <li>
                        <span>Available ZRH : <span class="inStockNum">{{ zrhInStockNum }}</span></span>
                        <span v-if="requiredNum.zrh - zrhInStockNum > 0" class="numWarn">* <span>{{ requiredNum.zrh - zrhInStockNum }}</span> more device required</span>
                        <input type="number" min="0" v-model="requiredNum.zrh" placeholder="Require ZRH">
                    </li>
                </ul>
            </div>
            <div class="btns">
                <button class="sendBtn" @click="toggleOrderRequestLightBox">Send Order Request</button>
                <OrderRequestLightBox v-if="orderRequestLightBoxDisplay" @closeOrderRequestLightBox="closeOrderRequestLightBox" :installer="installer" :user="$page.props.auth.user.name"></OrderRequestLightBox>
                <button class="confirmBtn" :class="confirmBtnDisabled? 'confirmBtnDisabled' : 'cofirmBtn'" :disabled="confirmBtnDisabled" @click="goToSupplyDoubleCheck(houseId)">Confirm</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.supplyCheck{
    width: 75vw;
    height: 80vh;
    margin: 0 auto;
    margin-top: 6vh;
    font-weight: 600;
}
h2{
    display: flex;
    flex-direction: row;
    align-items: center;
    padding-left: 10px;
}
h2 img{
    padding-right: 10px;
}
.numCheck{
    margin-top: 30px;
}
.numCheck ul li{
    display: flex;
    justify-content: space-between;
    padding: 10px 30px;
    margin-bottom: 20px;
    background-color: #f0f5f8;
    border-radius: 5px;
    align-items: center;
}
.numWarn{
    color: red;
}
.numCheck ul li input{
    border: none;
    background-color: #BAE1F5;
    width: 130px;
    border-radius: 5px;
    text-align: center;
}
.btns{
    display: flex;
    justify-content: space-between;
}
button{
    width: 350px;
    height: 50px;
    color: white;
    font-weight: 600;
    border-radius: 5px;
    background-color: #0096ff;
    margin-top: 50px;
}
.confirmBtnDisabled{
    background-color: #c9c8c8;
    color: black;
}
</style>