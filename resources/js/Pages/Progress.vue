<script setup>
    import { defineProps, onMounted, ref, computed } from 'vue';
    import { usePage } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import axios from 'axios';
    import designIcon from '/public/icons/design.svg';
    import contractIcon from '/public/icons/contract.svg';
    import supplyIcon from '/public/icons/supply.svg';
    import deliveryIcon from '/public/icons/delivery.svg';
    import installationIcon from '/public/icons/installation.svg';
    import greyDesignIcon from '/public/icons/greyDesignIcon.svg';
    import greyContractIcon from '/public/icons/greyContractIcon.svg';
    import greySupplyIcon from '/public/icons/greySupplyIcon.svg';
    import greyDeliveryIcon from '/public/icons/greyDeliveryIcon.svg';
    import greyInstallationIcon from '/public/icons/greyInstallationIcon.svg';
    import arrowIcon from '/public/icons/arrow.svg';
    import greyCheckIcon from '/public/icons/greyCheck.svg';
    import blueCheckIcon from '/public/icons/blueCheck.svg';
    import Progress from '@/Components/Progress.vue'; 
    import { Head } from '@inertiajs/vue3'

    const props = defineProps({
        houseId: String,
    });

    const userRole = usePage().props.auth.user.user_roles;

    const data = ref([{
        date: '',
        houseCode: '',
        address: '',
        client: '',
        progress: 0
    }]);

    onMounted(() => {
        getProject();
    });

    const designOn = computed(() => {
        if(data.value[0].progress >= 1){
            return true;
        }else{
            return false;
        }
    });
    const contractOn = computed(() => {
        if(data.value[0].progress >= 2){
            return true;
        }else{
            return false;
        }
    });
    const supplyOn = computed(() => {
        if(data.value[0].progress >= 3){
            return true;
        }else{
            return false;
        }
    });
    const installationOn = computed(() => {
        if(data.value[0].progress >= 4){
            return true;
        }else{
            return false;
        }
    });
    const deliveryOn = computed(() => {
        if(data.value[0].progress >= 5){
            return true;
        }else{
            return false;
        }
    });

    function getProject(){
        let url = '/api/v1/projects?houseId='+ props.houseId.toString();
        axios.get(url)
        .then((response) => {   
            data.value = response.data.data;
        })
    };
    
    function goToQuotation(houseId){
        location.assign(`/project/${houseId}/quotation`);
    };

    function goToContract(houseId){
        location.assign(`/project/${houseId}/contract`);
    };
    function goToSupply(houseId){
        location.assign(`/project/${houseId}/supply`);
    };
    function goToInstallation(houseId) {
        location.assign(`/project/${houseId}/installation`);
    };
    function goToIDelivery(houseId){
        location.assign(`/project/${houseId}/delivery`);
    };


    function toggleProgressBtn(status, isOn){
        let countStatus;
        if(isOn){
            countStatus = status - 1;
        }else{
            countStatus = status;
        }
        axios.patch('/api/v1/projects/'+ data.value[0].houseCode, {progress : countStatus})
        .then(() => {
            getProject();
        })
        .catch(error => {
            console.error('Failed to update project:', error);
        });
    };

    function goToProjects(){
        location.assign('/projects');
    };

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Progress" />

        <a class="backBtn" @click="goToProjects()"> &lt; Back To Projects</a>
        <div  class="wrapper">
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="date">Date</th>
                        <th scope="col" class="caseId">Case ID</th>
                        <th scope="col"  class="address">Address</th>
                        <th scope="col" class="customerName">Customer Name</th>
                        <th scope="col" class="progress">Progress</th>
                        <!-- <th scope="col" class="status">Status</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="date">{{ data[0].date }}</th>
                        <th class="caseId">{{ data[0].houseCode }}</th>
                        <th class="address">{{ data[0].address }}</th>
                        <th class="customerName">{{ data[0].client }}</th>
                        <th class="progress"><Progress :status="data[0].progress"></Progress></th>
                        <!-- <th class="status"></th> -->
                    </tr>
                </tbody>
            </table>
            <div class="progressBtns">
                <div>
                    <button class="linkBtn" @click="goToQuotation(houseId)" :class="data[0].progress >= 1 ? 'activeLinkBtn': ''" :disabled="userRole == 2 || userRole == 4"><img :src="data[0].progress >= 1 ? designIcon : greyDesignIcon ">Measurement<br>&Design</button>
                    <div class="checkBtn"><img :src="data[0].progress >= 1 ? blueCheckIcon : greyCheckIcon "></div>
                    <!-- <Button class="checkBtn" @click="toggleProgressBtn(1, designOn)"><img :src="data[0].progress >= 1 ? blueCheckIcon : greyCheckIcon "></Button> -->
                </div>
                <img :src="arrowIcon" class="arrow">
                <div>
                    <button class="linkBtn" @click="goToContract(houseId)" :class="data[0].progress >= 2 ? 'activeLinkBtn': ''" :disabled="userRole == 2 || userRole == 3"><img :src="data[0].progress >= 2 ? contractIcon : greyContractIcon " >Contract</button>
                    <div class="checkBtn"><img :src="data[0].progress >= 2 ? blueCheckIcon : greyCheckIcon "></div>
                    <!-- <Button class="checkBtn" @click="toggleProgressBtn(2, contractOn)"><img :src="data[0].progress >= 2 ? blueCheckIcon : greyCheckIcon "></Button> -->
                </div>
                <img :src="arrowIcon" class="arrow">
                <div>
                    <button class="linkBtn" @click="goToSupply(houseId)" :class="data[0].progress >= 3 ? 'activeLinkBtn': ''" :disabled="userRole == 2 || userRole == 3"><img :src="data[0].progress >= 3 ? supplyIcon : greySupplyIcon ">Check<br>Supplies</button>
                    <div class="checkBtn"><img :src="data[0].progress >= 3 ? blueCheckIcon : greyCheckIcon "></div>
                    <!-- <Button class="checkBtn" @click="toggleProgressBtn(3, supplyOn)"><img :src="data[0].progress >= 3 ? blueCheckIcon : greyCheckIcon "></Button> -->
                </div>
                <img :src="arrowIcon" class="arrow">
                <div>
                    <button class="linkBtn" @click="goToInstallation(houseId)" :class="data[0].progress >= 4 ? 'activeLinkBtn': ''" :disabled="userRole == 2 || userRole == 4"><img :src="data[0].progress >= 4 ? installationIcon : greyInstallationIcon ">Installation</button>
                    <div class="checkBtn"><img :src="data[0].progress >= 4 ? blueCheckIcon : greyCheckIcon "></div>
                    <!-- <Button class="checkBtn" @click="toggleProgressBtn(4, installationOn)"><img :src="data[0].progress >= 4 ? blueCheckIcon : greyCheckIcon "></Button> -->
                </div>
                <img :src="arrowIcon" class="arrow">
                <div>
                    <button class="linkBtn" @click="goToIDelivery(houseId)" :class="data[0].progress >= 5 ? 'activeLinkBtn': ''" :disabled="userRole == 2 || userRole == 3"><img :src="data[0].progress >= 5 ? deliveryIcon : greyDeliveryIcon ">Delivery</button>
                    <div class="checkBtn"><img :src="data[0].progress >= 5 ? blueCheckIcon : greyCheckIcon "></div>
                    <!-- <Button class="checkBtn" @click="toggleProgressBtn(5, deliveryOn)"><img :src="data[0].progress >= 5 ? blueCheckIcon : greyCheckIcon "></Button> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
  
<style scoped>
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
.wrapper{
    width: 70vw;
    margin: 0 auto;
    margin-top: 15vh;
}
table{
    width: 100%;
    text-align: left;
}
table thead tr{
    width: 100%;
}
table tbody tr{
    width: 100%;
}
table tbody tr th{
    font-weight: 200;
}
.progressBtns{
    margin-top: 20vh;
    display: flex;
    justify-content: space-between;
}
.arrow{
    /* outline: 1px solid; */
    padding-bottom: 30px;
}
.progressBtns>div{
    display: flex;
    flex-direction: column;
    align-items: center;
}
.linkBtn{
    width: 120px;
    height: 140px;
    text-align: center;
    background-color: #f0f5f8;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    padding-top: 20px;
    font-weight: 500;
    color: #a3aeb5;
}
.linkBtn:hover{
    background-color: #c8d5dc;
}
.activeLinkBtn{
    color: black;
    background-color: #bae1f5;
}
.activeLinkBtn:hover{
    background-color: #a9cee0;
}
.checkBtn{
    padding-top: 30px;
}
.dashed-arrow {
        width: 0;
        height: 0;
        border-top: 10px dashed black;
        border-right: 10px solid transparent;
        border-bottom: 10px dashed black;
        border-left: 10px solid transparent;
}
</style>
  