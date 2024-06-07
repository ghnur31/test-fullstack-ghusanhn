<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Add Address</h4>
      </div>
      <div class="card-body">
        <ul
          class="alert alert-warning"
          v-if="Object.keys(this.errorList).length > 0"
        >
          <li
            class="mb-0 ms-3"
            v-for="(error, index) in this.errorList"
            :key="index"
          >
            {{ error[0] }}
          </li>
        </ul>
        <div class="mb-3">
          <label for="recipient_name" class="form-label">Recipient Name</label>
          <input
            type="text"
            v-model="model.address.recipient_name"
            class="form-control"
            id="recipient_name"
          />
        </div>
        <div class="mb-3">
          <label for="address_name" class="form-label">Address Name</label>
          <input
            type="text"
            v-model="model.address.address_name"
            class="form-control"
            id="address_name"
          />
        </div>
        <div class="mb-3">
          <label for="address_detail" class="form-label">Address Detail</label>
          <input
            type="text"
            v-model="model.address.address_detail"
            class="form-control"
            id="address_detail"
          />
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input
            type="text"
            v-model="model.address.phone"
            class="form-control"
            id="phone"
          />
        </div>
        <div class="mb-3">
          <label for="postal_code" class="form-label">Postal Code</label>
          <input
            type="text"
            v-model="model.address.postal_code"
            class="form-control"
            id="postal_code"
          />
        </div>
        <div class="mb-3">
          <button type="button" @click="saveAddress" class="btn btn-primary">
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AddressCreate",
  data() {
    return {
      customerId: '',
      errorList: "",
      model: {
        address: {
          recipient_name: "",
          address_name: "",
          address_detail: "",
          phone: "",
          postal_code: "",
          customer_id: this.$route.params.customerId // Menambah customer_id dari route params
        },
      },
    };
  },
  mounted() {
    this.customerId = this.$route.params.customerId;
  },
  methods: {
    saveAddress() {
      var myThis = this;
      axios
        .post(`http://127.0.0.1:8000/api/addresses`, this.model.address)
        .then((res) => {
          console.log(res.data);
          alert(res.data.message);

          // Redirect ke halaman detail customer setelah berhasil
          this.$router.push(`/customers/${this.customerId}`);

          // Reset form
          this.model.address = {
            recipient_name: "",
            address_name: "",
            address_detail: "",
            phone: "",
            postal_code: "",
            customer_id: this.$route.params.customerId
          };
          this.errorList = "";
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status === 422) {
              myThis.errorList = error.response.data.errors;
            }
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
        });
    },
  },
};
</script>

<style>
</style>
