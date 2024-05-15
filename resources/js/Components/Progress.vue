<script setup>
    import { defineProps } from 'vue';

    const props = defineProps({
        status : Number,
    })
</script>
<template>
    <div class="progressWrapper">
        <span :class="props.status >= 1? 'activeNum': ''">1</span>
        <span :class="props.status >= 2? 'activeNum': ''">2</span>
        <span :class="props.status >= 3? 'activeNum': ''">3</span>
        <span :class="props.status >= 4? 'activeNum': ''">4</span>
        <span :class="props.status >= 5? 'activeNum': ''">5</span>
    </div>
</template>
<style scoped>
.progressWrapper{
    display: flex;

}
span{
    display: block;
    margin-right: 1px;
    background-color: #dadada;
    width: 15%;
    text-align: center;

}
.activeNum{
    background-color: #bae1f5;
}
</style>