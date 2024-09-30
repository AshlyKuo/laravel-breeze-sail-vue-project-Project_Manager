<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import BackBtn from '@/Components/BackToProgress.vue';
    import deliveryIcon from '/public/icons/delivery.svg';
    import { defineProps, ref, onMounted } from 'vue';
    import axios from 'axios';
    import { Head } from '@inertiajs/vue3'

    const props = defineProps({
        houseId: String,
    });

    const btnDisabled = ref(true);
    const image = ref(null);
    const data = ref();
    const houseCode = ref();
    const picId = ref();
    const pic = ref({
        name: '',
        url: '',
        houseId: props.houseId,
        houseCode: '',
        type: 'S',
    });
    const filename = ref('');
    const fileUrl = ref('');


    onMounted(() => {
        const url = '/api/v1/projects?houseId=' + props.houseId;
        axios.get(url)
        .then((response) => {   
            data.value = response.data.data;
            pic.value.houseCode = response.data.data[0].houseCode;
            // console.log(pic.value);
        })
        pic.value.name = props.houseId + '_signature'; 

        // 若已有pic，將照片顯示於畫面中
        let picUrl = '/api/v1/pictures?houseId=' + props.houseId + '&type=S';
        axios.get(picUrl)
        .then((response) => {
            pic.value.url = response.data.data[0].url;
            picId.value = response.data.data[0].id
        })
    });

    function handleFileUpload(event) {
        // console.log(event.target.files[0]);
        image.value = event.target.files[0];
        btnDisabled.value = false;
        filename.value = event.target.files[0].name;

        if(image.value){
            const reader = new FileReader();
            reader.onload = (e) => {
                fileUrl.value = e.target.result;
            }
            reader.readAsDataURL(image.value);
        }

    };

    async function uploadPhoto() {
        try {
            const checkResponse = await axios.get('/api/v1/pictures?name=' + pic.value.name + '&houseId=' + pic.value.houseId + '&type=S');
            // 若照片已存在
            if (checkResponse.data.data.length) { 
                console.log(checkResponse);
                let replace = confirm("Signature has existed. Replace?");
                if(replace){
                    const formData = new FormData();
                    formData.append('path',pic.value.url);
                    await axios.post('/deletePicture', formData)
                    .then(()=>{})
                    .catch(error => {
                        console.log(error);
                    })

                    formData.append('image', image.value);

                    const uploadResponse = await axios.post('/uploadPicture', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    });
                    pic.value.url = 'https://s3.ap-northeast-1.amazonaws.com/s3.zap/' + uploadResponse.data.path;

                    // console.log(picId.value);

                    await axios.patch('/api/v1/pictures/' + picId.value , {url: pic.value.url})
                    .then(() => {})
                    .catch(error => {
                        console.log(error.response);
                    } )
                    filename.value = '';
                    fileUrl.value = '';
                    return;

                }else{
                    return; 
                }
            }else{
                const formData = new FormData();
                formData.append('image', image.value);

                const uploadResponse = await axios.post('/uploadPicture', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                // console.log(uploadResponse);
                pic.value.url = 'https://s3.ap-northeast-1.amazonaws.com/s3.zap/' + uploadResponse.data.path;

                const saveResponse = await axios.post('/api/v1/pictures', pic.value);

                alert('Contract Upload Sucess');
                filename.value = '';
                fileUrl.value = '';

            }

        } catch (error) {
            console.error(error);
            alert('Contract Upload Fail. Please try again');
        }
    };

    function completeProgressFive(){
        axios.patch('/api/v1/projects/'+ pic.value.houseCode, {progress : 5, completed: 1})
        .then(() => {
            // 成功變回到progress頁面
            location.assign(`/project/${props.houseId}/progress`);
        })
        .catch(error => {
                    console.error('Failed to update process:', error);
        });

    }



</script>
<template>
    <AuthenticatedLayout>
        <Head title="Delivery" />
        <BackBtn :houseId="houseId"></BackBtn>
        <div class="delivery">
            <h2><img :src="deliveryIcon">Upload Signature</h2>
            <div class="form">
                <div :class="pic.url == '' ? 'input' : 'imgInput'">
                    <img :class="pic.url == '' ? '': 'imgDivImg'" :src="pic.url" alt="">
                    <label for="uploadPhoto" :class="pic.url == '' ? '': 'imgLabel'">Choose File</label>
                    <input id="uploadPhoto" type="file" accept="image/*,  application/pdf" @change="handleFileUpload" style="display: none;">
                </div>
                <h5 v-if="fileUrl">Chosen file:</h5>
                <img class="preViewImg" :src="fileUrl" v-if="fileUrl != ''" alt="Uploaded Image" style="max-width: 200px; max-height: 80px;">
                <h5 class="previewName">{{ filename }}</h5>
            </div>
            <div class="btns">
                <button @click="uploadPhoto" :class="btnDisabled ? 'btnDisabled' : 'saveBtn'" :disabled="btnDisabled">Save</button>
                <button @click="completeProgressFive">Complete</button>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.delivery{
    width: 80vw;
    height: 80vh;
    margin: 0 auto;
    margin-top: 6vh;
}
h2{
   font-weight: 600;
   padding-bottom: 20px;
   padding-left: 5%; 
   display: flex;
   align-items: center;
}
h2 img{
    padding-left: 10px;
    padding-right: 20px;
    height: 50px;
}
.form{
    height: 85%;
    width: 90%;
    margin: 0 auto;
    border: 2px solid #BAE1F5;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.form>div{
    display: flex;
    flex-direction: column;
    align-items: center;
}
.imgInput{
    width: 400px;
    height: 70%;
    margin: 0 auto;
}
.input{
    width: 200px;
    height: 100px;
    border-radius: 5px;
    background-color: #BAE1F5;
    margin: auto 0;
}
label{
    padding: 5px;
    border-radius: 5px;
    /* margin: auto 0; */
    margin-top: 20px;
    background-color: white;    
}
label:hover{
    background-color: #e4e4e4;
    cursor: pointer;
}
.imgLabel{
    border: 1px solid #BAE1F5;
}
.imgLabel:hover{
    background-color: #BAE1F5;
}
.imgDivImg{
    height: 60%;
    margin-top: 20px;
}
.preViewImg{
    margin-top: 10px;
    height: 15%;
}
.btns{
    display: flex;
    width: 70vw;
    margin: 0 auto;
    justify-content: space-around;
    margin-top: 30px;
}
button{
    font-weight: 800;
    width: 250px;
    /* margin-left: calc((80vw - 300px) / 2); */
    height: 30px;
    border-radius: 5px;
    background-color: #0096ff;
    color: white;
}

.saveBtn{
    background-color: #0096ff;
    color: white;
}
.btnDisabled{
    background-color: #c9c8c8;
    color: black;
}
</style>