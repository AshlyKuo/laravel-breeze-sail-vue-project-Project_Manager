<script setup>
    import TableLite from 'vue3-table-lite';
    import { reactive, ref, watch, onMounted  } from 'vue';
    import axios from 'axios';
    import AddUser from '@/Components/AddUser.vue';
    import EditUser from '@/Components/UserEditLightBox.vue';

    const searchTerm = ref("");
    const newUsertLightBoxDisplay = ref(false);
    const userEditLightBoxDisplay= ref(false);
    const editUserId = ref();

    onMounted(() => {
        const elements = document.querySelectorAll('.vtl-table');

        elements.forEach(element => {
            element.classList.remove('vtl-table-responsive-sm', 'vtl-table-responsive');
        });

    });

    function toggleLightBox(){
        newUsertLightBoxDisplay.value = ! newUsertLightBoxDisplay.value;
    };

    function closeForm(value){
        newUsertLightBoxDisplay.value = value;
        userEditLightBoxDisplay.value = value;
        doSearch(0, 10, 'id', 'desc');
    };


    const table = reactive({
    isLoading: false,
    isReSearch: false,
    columns: [
        {
            label: "Name",
            field: "name",
            width: "20%",
            sortable: true,
        },
        {
            label: "Email",
            field: "email",
            width: "20%",
            sortable: true,
        },
        {
            label: "User Roles",
            field: "userRoles",
            width: "20%",
            sortable: true,
            display: function(row){
                let content;
                if(row.userRoles == 1){
                    content = 'MIS'
                }else if( row.userRoles == 2){
                    content = 'Chairman'
                }else if( row.userRoles == 3){
                    content = 'MJ'
                }else if( row.userRoles == 4){
                    content = 'Addwii'
                };
                return(
                    '<div>'+ content +'</div>'
                );
            }
        },
        {
            label: "",
            field: "quick",
            width: "5%",
            display: function (row) {
                return (
                '<button type="button" data-id="' +
                row.id +
                '" class="is-rows-el quick-btn editBtn">Edit</button>'
                );
            },
        },
        {
            label: "",
            field: "quick",
            width: "5%",
            display: function (row) {
                return (
                '<button type="button"data-id="' +
                row.id +
                '" class="is-rows-el quick-btn deleteBtn">Delete</button>'
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
    let url = '/api/v1/users';

    axios.get(url)
    .then((response) => {
        let filteredData = response.data.data;
        if (searchTerm.value) {
            filteredData = response.data.data.filter(x =>
                x.name?.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
                x.email?.toLowerCase().includes(searchTerm.value.toLowerCase())
            );
        }

        table.rows = filteredData;
        table.totalRecordCount = filteredData.length;
        table.sortable.order = order;
        table.sortable.sort = sort;
    });

    };

    const tableLoadingFinish = (elements) => {
      table.isLoading = false;
      Array.prototype.forEach.call(elements, function (element) {
        if (element.classList.contains("editBtn")) {
          element.addEventListener("click", function () {
            const userId = this.getAttribute('data-id');
            editUserId.value = userId;
            userEditLightBoxDisplay.value = true;
          });
        }
        if (element.classList.contains("deleteBtn")) {
          element.addEventListener("click", function () {
            const userId = this.getAttribute('data-id');

            let confirmation = confirm('Confirm to delete user '+ userId);

            if(confirmation){
                axios.delete('/api/v1/users/' +  userId )
                .then(response => {
                    alert('User '+ userId + ' has been deleted');
                    doSearch(0, 10, 'id', 'desc');
                })
                .catch(error => {
                    console.log(error);
                })
            }

          });
        }
      });

    };


    watch( () => searchTerm.value , () => {
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
            <button @click="toggleLightBox" class="newProjectBtn">Add New User</button>          
        </div>
        <AddUser v-if="newUsertLightBoxDisplay" @closeForm="closeForm"></AddUser>
        <EditUser v-if="userEditLightBoxDisplay" @closeForm="closeForm" :userId="editUserId"></EditUser>
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
<style scoped>

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
select{
    padding: 3px 24px !important;
}
.quick-btn{
    /* background-color: cadetblue; */
    font-weight: 600;
}
.quick-btn:hover{
    text-decoration: underline;
}

</style>