<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4 class="text-center">Edit Address</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="updateAddress">
          <div class="mb-3">
            <label for="recipientName" class="form-label">Recipient Name</label>
            <input type="text" class="form-control" id="recipientName" v-model="form.recipient_name">
          </div>
          <div class="mb-3">
            <label for="addressName" class="form-label">Address Name</label>
            <input type="text" class="form-control" id="addressName" v-model="form.address_name">
          </div>
          <div class="mb-3">
            <label for="addressDetail" class="form-label">Address Detail</label>
            <textarea class="form-control" id="addressDetail" v-model="form.address_detail"></textarea>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" v-model="form.phone">
          </div>
          <div class="mb-3">
            <label for="postalCode" class="form-label">Postal Code</label>
            <input type="text" class="form-control" id="postalCode" v-model="form.postal_code">
          </div>
          <button type="submit" class="btn btn-primary">Update Address</button>
          <router-link :to="{ path: `/customers/${customerId}` }" class="btn btn-secondary ms-2">Cancel</router-link>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "EditAddress",
  data() {
    return {
      form: {
        recipient_name: "",
        address_name: "",
        address_detail: "",
        phone: "",
        postal_code: "",
      },
      customerId: null,
      addressId: null,
    };
  },
  mounted() {
    this.customerId = this.$route.params.customerId;
    this.addressId = this.$route.params.addressId;
    this.getAddressData();
  },
  methods: {
    getAddressData() {
      axios.get(`http://127.0.0.1:8000/api/addresses/${this.addressId}/edit`)
        .then((res) => {
          this.form = res.data.address;
        })
        .catch((error) => {
          console.error(error);
          alert('Failed to fetch address data.');
        });
    },
    updateAddress() {
      axios.put(`http://127.0.0.1:8000/api/addresses/${this.addressId}/edit`, this.form)
        .then((res) => {
          alert(res.data.message);
          // Redirect back to customer detail page after successful update
          this.$router.push(`/customers/${this.customerId}`);
        })
        .catch((error) => {
          console.error(error);
          alert('Failed to update address.');
        });
    },
  },
};
</script>

<style>
</style>
