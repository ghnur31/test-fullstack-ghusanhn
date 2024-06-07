<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4 class="text-center">Customer Details</h4>
      </div>
      <div class="card-body">
        <div class="row mb-4 pb-4 border-bottom">
          <h5 class="mb-3">Customer Information</h5>          
          <div class="col-md-3">
            <img v-if="customer.photo" :src="customer.photo" alt="Customer Photo" class="img-fluid mb-3" style="max-height: 200px;"/>
          </div>
          <div class="col-md-9">
            <p><strong>Name:</strong> {{ customer.name }}</p>
            <p><strong>Email:</strong> {{ customer.email }}</p>
            <p><strong>Phone:</strong> {{ customer.phone }}</p>
            <p><strong>Gender:</strong> {{ customer.gender }}</p>
            <p><strong>Birth Date:</strong> {{ formatBirthDate(customer.birth_date) }}</p>
          </div>
        </div>

        <div>
          <h5>Addresses</h5>
          <table class="table table-bordered">
            <thead class="text-center fw-bold">
              <tr>
                <th class="fw-bold">No.</th>
                <th class="fw-bold">Recipient Name</th>
                <th class="fw-bold">Address Name</th>
                <th class="fw-bold">Detail Address</th>
                <th class="fw-bold">Phone</th>
                <th class="fw-bold">Postal Code</th>
                <th class="fw-bold">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(address, index) in customer.addresses" :key="address.id">
                <td>{{ index + 1 }}</td>
                <td>{{ address.recipient_name }}</td>
                <td>{{ address.address_name }}</td>
                <td>{{ address.address_detail }}</td>
                <td>{{ address.phone }}</td>
                <td>{{ address.postal_code }}</td>
                <td class="d-flex justify-content-around">
                  <router-link :to="{ path: `/customers/${customer.id}/addresses/${address.id}/edit/` }" class="btn btn-warning">Edit</router-link>
                  <button type="button" @click="deleteAddress(address.id)" class="btn btn-danger">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
          <router-link :to="{ path: `/customers/${customer.id}/addresses/create/` }" class="btn btn-primary">Add Address</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CustomerDetail",
  data() {
    return {
      customer: {},
    };
  },
  mounted() {
    this.getCustomerData(this.$route.params.id);
  },
  methods: {
    getCustomerData(customerId) {
      axios.get(`http://127.0.0.1:8000/api/customers/${customerId}`)
        .then((res) => {
          this.customer = res.data.customer;
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 404) {
              alert(error.response.data.message);
            }
          }
        });
    },
    deleteAddress(addressId) {
      if (confirm('Are you sure you want to delete this address?')) {
        axios.delete(`http://127.0.0.1:8000/api/addresses/${addressId}/delete`)
          .then((res) => {
            alert(res.data.message);
            this.getCustomerData(this.$route.params.id);
          })
          .catch((error) => {
            console.error(error);
            alert('Failed to delete address.');
          });
      }
    },
    formatBirthDate(dateString) {
      if (dateString) {
        const dateObject = new Date(dateString);
        return dateObject.toLocaleDateString('en-GB'); 
      }
      return '';
    },
  },
};
</script>

<style>
</style>
