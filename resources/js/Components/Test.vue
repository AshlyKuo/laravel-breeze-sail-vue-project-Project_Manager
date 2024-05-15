<template>
    <div style="text-align: left">
      <label>SearchBy:</label><input v-model="searchTerm" />
    </div>
    <table-lite
      :is-slot-mode="true"
      :is-static-mode="true"
      :columns="table.columns"
      :rows="filteredRows"
      :total="table.totalRecordCount"
      :sortable="table.sortable"
    >
      <template v-slot:name="data">
        <Test>
          {{ data.value.name }}
        </Test>
      </template>
    </table-lite>
  </template>
  
  <script setup>
  import { ref, reactive, computed } from 'vue';
  import TableLite from 'vue3-table-lite';
  
  const searchTerm = ref(""); // Search text
  
  // Fake data
  const data = reactive([]);
  for (let i = 0; i < 126; i++) {
    data.push({
      id: i,
      name: "TEST" + i,
      email: "test" + i + "@example.com",
    });
  }
  
  // Table config
  const table = reactive({
    columns: [
      {
        label: "ID",
        field: "id",
        width: "3%",
        sortable: true,
        isKey: true,
      },
      {
        label: "Name",
        field: "name",
        width: "10%",
        sortable: true,
      },
      {
        label: "Email",
        field: "email",
        width: "15%",
        sortable: true,
      },
    ],
    totalRecordCount: computed(() => {
      return filteredRows.value.length;
    }),
    sortable: {
      order: "id",
      sort: "asc",
    },
  });
  
  const filteredRows = computed(() => {
    return data.filter(
      (x) =>
        x.email.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        x.name.toLowerCase().includes(searchTerm.value.toLowerCase())
    );
  });
  </script>
  