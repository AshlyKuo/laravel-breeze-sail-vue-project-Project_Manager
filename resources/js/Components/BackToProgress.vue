<script setup>
    import { defineProps } from 'vue';

    const props = defineProps(
        {
            houseId: Number
        }
    );

    function goToProgress(houseId){
        location.assign(`/project/${houseId}/progress`);
    }

</script>
<template>
    <a class="backBtn" @click="goToProgress(houseId)"> < Back To Progress</a>
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
</style>