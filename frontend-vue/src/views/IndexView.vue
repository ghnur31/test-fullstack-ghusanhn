<template>
  <div class="container mt-5">
    <h1 class="mb-3">List Customers</h1>
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search customer..."
      class="border rounded p-2 mb-4"
      @input="searchCustomers"
    />
    <div class="card">
      <div class="card-header">
        <h4>
          Customers
          <router-link to="/customers/create" class="btn btn-primary float-end">
            Add Customer
          </router-link>
        </h4>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr class="text-center fw-bold">
              <th class="fw-bold">ID</th>
              <th class="fw-bold">Name</th>
              <th class="fw-bold">Email</th>
              <th class="fw-bold">Phone</th>
              <th class="fw-bold">Gender</th>
              <th class="fw-bold">Birth Date</th>
              <th class="fw-bold">Action</th>
            </tr>
          </thead>
          <tbody v-if="customers.length > 0">
            <tr v-for="(customer, index) in customers" :key="customer.id">
              <td>{{ index + 1 }}</td>
              <td>{{ customer.name }}</td>
              <td>{{ customer.email }}</td>
              <td>{{ customer.phone }}</td>
              <td>{{ customer.gender }}</td>
              <td>{{ formatBirthDate(customer.birth_date) }}</td>
              <td class="d-flex justify-content-around">
                <router-link :to="{ path: '/customers/' + customer.id }" class="btn btn-success">Detail</router-link>
                <router-link :to="{ path: '/customers/' + customer.id + '/edit' }" class="btn btn-warning">Edit</router-link>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td colspan="8">Loading ...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Customers",
  data() {
    return {
      customers: [],
      searchQuery: "",
    };
  },
  mounted() {
    this.getCustomers();
  },
  methods: {
    getCustomers() {
      let url = "http://127.0.0.1:8000/api/customers";
      if (this.searchQuery) {
        url += `?search=${this.searchQuery}`;
      }
      axios.get(url)
        .then((res) => {
          this.customers = res.data.customers;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    searchCustomers() {
      this.getCustomers();
    },
    formatBirthDate(dateString) {
      if (dateString) {
        const dateObject = new Date(dateString);
        return dateObject.toLocaleDateString('en-GB'); // Change the locale according to your preference
      }
      return '';
    },
  },
};
</script>
