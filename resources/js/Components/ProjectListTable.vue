<script setup>
  import { ref, reactive, watch, computed, onMounted, onBeforeMount } from 'vue';
  import TableLite from 'vue3-table-lite';
  import NewProjectLightBox from './NewProjectLightBox.vue';

  const searchTerm = ref("");
  const newProjectLightBoxDisplay = ref(false);
  const isEditable = ref(true);
  const props = defineProps({
    progressStatus: String,
    userRoles: Number,
  });

  watch(() => props.progressStatus, (newStatus, oldStatus) => {
    if(newStatus == 'inProgress'){
        table.columns = [
        {
            label: "Date",
            field: "date",
            width: "3%",
            sortable: true,
        },
        {
            label: "House Code",
            field: "houseCode",
            width: "10%",
            sortable: false,
        },
        {
            label: "Client",
            field: "client",
            width: "15%",
            sortable: false,
        },
        {
            label: "Sales",
            field: "sales",
            width: "15%",
            sortable: true,
        },
        {
            label: "Installer",
            field: "installer",
            width: "15%",
            sortable: false,
        },
        {
            label: "Amounts",
            field: "amounts",
            width: "15%",
            sortable: true,
        },
        {
            label: "Progress",
            field: "currentProgress",
            width: "15%",
            sortable: false,
            display: function(row) {
                let activeOne;
                let activeTwo;
                let activeThree;
                let activeFour;
                let activeFive;

                if( row.progress >= 1){
                    activeOne = 'activeNum';
                }else{
                    activeOne = ''
                };
                if( row.progress >= 2){
                    activeTwo = 'activeNum';
                }else{
                    activeTwo = ''
                };
                if( row.progress >= 3){
                    activeThree = 'activeNum';
                }else{
                    activeThree = ''
                };
                if( row.progress >= 4){
                    activeFour = 'activeNum';
                }else{
                    activeFour = ''
                };
                if( row.progress >= 5){
                    activeFive = 'activeNum';
                }else{
                    activeFive = ''
                };

                return (
                    '<div class="flex flex-row progress"><span class="numSpan '+ activeOne +'">1</span><span class="numSpan '+ activeTwo +'">2</span><span class="numSpan '+ activeThree +'">3</span><span class="numSpan '+ activeFour +'">4</span><span class="numSpan '+ activeFive +'">5</span></div>'
                );
            },
        },
        {
            label: "",
            field: "quick",
            width: "10%",
            display: function (row) {
                let content;
                if(props.userRoles == 2){
                    content = 'View >';
                }else{
                    content = 'Edit >';
                }
                return (
                '<button type="button" data-id="' +
                row.houseId +
                '" class="is-rows-el quick-btn editBtn">'+ content +'</button>'
                );
            },
        },

        ]
    }else{
        table.columns = [
        {
            label: "Date",
            field: "date",
            width: "3%",
            sortable: true,
        },
        {
            label: "House Code",
            field: "houseCode",
            width: "10%",
            sortable: false,
        },
        {
            label: "Client",
            field: "client",
            width: "15%",
            sortable: false,
        },
        {
            label: "Sales",
            field: "sales",
            width: "15%",
            sortable: true,
        },
        {
            label: "Installer",
            field: "installer",
            width: "15%",
            sortable: false,
        },
        {
            label: "Amounts",
            field: "amounts",
            width: "15%",
            sortable: true,
        },
        // {
        //     label: "Client Satisfaction",
        //     field: "clientSatisfaction",
        //     width: "15%",
        //     sortable: false,
        //     display: function(row) {
        //         return (
        //             '<div class="flex flex-row progress"><span :class="{'+"'active': 1== "+row.clientSatisfaction+'}">'+ row.clientSatisfaction +'</span></div>'
        //         );
        //     },
        // },
        {
            label: "",
            field: "quick",
            width: "10%",
            display: function (row) {
                return (
                '<button type="button" data-id="' +
                row.houseId +
                '" class="is-rows-el quick-btn editBtn">View > </button>'
                );
            },
        },

        ]
    }
  });

  function toggleLightBox(){
    newProjectLightBoxDisplay.value = ! newProjectLightBoxDisplay.value;
  };

  function closeForm(value){
    newProjectLightBoxDisplay.value = value;
  };
  
  const table = reactive({
    isLoading: false,
    isReSearch: false,
    columns: [
        {
            label: "Date",
            field: "date",
            width: "3%",
            sortable: true,
        },
        {
            label: "House Code",
            field: "houseCode",
            width: "10%",
            sortable: false,
        },
        {
            label: "Client",
            field: "client",
            width: "15%",
            sortable: false,
        },
        {
            label: "Sales",
            field: "sales",
            width: "15%",
            sortable: true,
        },
        {
            label: "Installer",
            field: "installer",
            width: "15%",
            sortable: false,
        },
        {
            label: "Amounts",
            field: "amounts",
            width: "15%",
            sortable: true,
        },
        {
            label: "Progress",
            field: "currentProgress",
            width: "15%",
            sortable: false,
            display: function(row) {
                let activeOne;
                let activeTwo;
                let activeThree;
                let activeFour;
                let activeFive;

                if( row.progress >= 1){
                    activeOne = 'activeNum';
                }else{
                    activeOne = ''
                };
                if( row.progress >= 2){
                    activeTwo = 'activeNum';
                }else{
                    activeTwo = ''
                };
                if( row.progress >= 3){
                    activeThree = 'activeNum';
                }else{
                    activeThree = ''
                };
                if( row.progress >= 4){
                    activeFour = 'activeNum';
                }else{
                    activeFour = ''
                };
                if( row.progress >= 5){
                    activeFive = 'activeNum';
                }else{
                    activeFive = ''
                };

                return (
                    '<div class="flex flex-row progress"><span class="numSpan '+ activeOne +'">1</span><span class="numSpan '+ activeTwo +'">2</span><span class="numSpan '+ activeThree +'">3</span><span class="numSpan '+ activeFour +'">4</span><span class="numSpan '+ activeFive +'">5</span></div>'
                );
            },

        },
        {
            label: "",
            field: "quick",
            width: "10%",
            display: function (row) {
                let content;
                if(props.userRoles == 2){
                    content = 'View >';
                }else{
                    content = 'Edit >';
                }
                return (
                '<button type="button" data-id="' +
                row.houseId +
                '" class="is-rows-el quick-btn editBtn">'+ content +'</button>'
                );
            },
        },
    ],
    rows: [],
    totalRecordCount: 0,
    sortable: {
        order: "id",
        sort: "asc",
    },
    messages: {
        pagingInfo: "Showing {0}-{1} of {2}",
        pageSizeChangeLabel: "Row count:",
        gotoPageLabel: "Go to page:",
        noDataAvailable: "No data",
    },

  });

  const doSearch = (offset, limit, order, sort) => {
    table.isLoading = true;
    let url = '';
    if(props.progressStatus == 'inProgress'){
        url = '/api/v1/projects?completed=0'
    }else{
        url = '/api/v1/projects?completed=1'
    }

    axios.get(url)
    .then((response) => {
        let filteredData = response.data.data;
        if (searchTerm.value) {
            filteredData = response.data.data.filter(x =>
                x.houseCode?.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
                x.client?.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
                x.sales?.toLowerCase().includes(searchTerm.value.toLowerCase())  ||
                x.installer?.toLowerCase().includes(searchTerm.value.toLocaleLowerCase())
            );
        }

        table.rows = filteredData;
        table.totalRecordCount = filteredData.length;
        table.sortable.order = order;
        table.sortable.sort = sort;
    });

    };

    /**
    * Table search finished event
    */
    const tableLoadingFinish = (elements) => {
      table.isLoading = false;
      Array.prototype.forEach.call(elements, function (element) {
        if (element.classList.contains("editBtn")) {
          element.addEventListener("click", function () {
            const houseId = this.getAttribute('data-id');
            location.assign(`/project/${houseId}/progress`);
          });
        }
      });
    };

    watch([() => props.progressStatus, () => newProjectLightBoxDisplay.value, () => searchTerm.value ], () => {
        doSearch(0, 10, 'id', 'desc');
    });


    // Get data first
    doSearch(0, 10, 'id', 'desc');


   

</script>

<template>
    <div class="table">
        <div class="controlArea">
            <div class="search">
               <input v-model="searchTerm" placeholder="Search"/>
            </div>          
            <button @click="toggleLightBox" class="newProjectBtn" v-if="props.userRoles != 2">Add New Project</button>
        </div>
        <NewProjectLightBox v-if="newProjectLightBoxDisplay" @closeForm="closeForm"></NewProjectLightBox>
        <table-lite
            :is-slot-mode="true"
            :is-static-mode="true"
            :columns="table.columns"
            :rows="table.rows"
            :total="table.totalRecordCount"
            :sortable="table.sortable"
            @is-finished="tableLoadingFinish"
        />
    </div>
</template>  
<style scope>
    .table{
        padding: 10px;
        width: 100%;
    }
    .controlArea{
        display: flex;
        flex-direction: row;
        padding-bottom: 5px;
    }
    .search{
        width: 50%;
    }
    .search input{
        width: 96%;
        border: none;
        background-color: #f0f5f8;
        border-radius: 5px;
    }
    .newProjectBtn{
        width: 50%;
        background-color: #BAE1F5;
        border-radius: 5px;
    }
    .vtl-card{
        height: 70% !important;
    }
    .vtl-table thead th {
    color: #000 !important;
    background-color: #fff !important;
    border-color: inherit !important;
    border: none !important;
    }

    .vtl-table-bordered td{
        border: none !important;
    }
    .vtl-table-bordered td{
        border: none !important;
    }
    .vtl-table td{
        border: none !important;
    }
    tbody tr:nth-child(odd){
        background-color: #F0F5F8
    }
    .quick-btn{
        font-weight: 600;
    }
    .quick-btn:hover{
        text-decoration: underline;
    }
    select{
        padding: 3px 24px !important;
    }

    .numSpan{
        display: block;
        width: 14%;
        margin-right: 1.5px;
        background-color: #dadada;
        text-align: center;
    }

    .activeNum{
        background-color: #bae1f5;
    }
</style>
