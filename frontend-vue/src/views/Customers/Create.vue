<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Add Customers</h4>
      </div>
      <div class="card-body">
        <ul class="alert alert-warning" v-if="Object.keys(errorList).length > 0">
          <li class="mb-0 ms-3" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
        </ul>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="model.customer.name" class="form-control" id="name" />
        </div>
        <div class="mb-3">
          <label for="photo" class="form-label">Photo</label>
          <input type="file" ref="photo" @change="handleFileUpload" class="form-control" id="photo" accept="image/jpeg, image/png" />
          <div v-if="photoPreview" class="mt-2">
            <img :src="photoPreview" alt="Photo Preview" class="img-fluid" style="max-height: 200px;" />
          </div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" v-model="model.customer.email" class="form-control" id="email" />
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="text" v-model="model.customer.phone" class="form-control" id="phone" />
        </div>
        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select v-model="model.customer.gender" class="form-control" id="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="birth_date" class="form-label">Birth Date</label>
          <input type="date" v-model="model.customer.birth_date" class="form-control" id="birth_date" />
        </div>
        <div class="mb-3">
          <button type="button" @click="saveCustomer" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "customerCreate",
  data() {
    return {
      errorList: {},
      model: {
        customer: {
          name: "",
          photo: "",
          email: "",
          phone: "",
          gender: "",
          birth_date: "",
        },
      },
      photoPreview: null,
    };
  },
  methods: {
    saveCustomer() {
      let formData = new FormData();
      formData.append("name", this.model.customer.name);
      formData.append("photo", this.model.customer.photo);
      formData.append("email", this.model.customer.email);
      formData.append("phone", this.model.customer.phone);
      formData.append("gender", this.model.customer.gender);
      formData.append("birth_date", this.model.customer.birth_date);

      axios
        .post("http://127.0.0.1:8000/api/customers", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          console.log(this.model.customer);
          alert(res.data.message);

          this.model.customer = {
            name: "",
            photo: "",
            email: "",
            phone: "",
            gender: "",
            birth_date: "",
          };
          this.errorList = {};
          this.photoPreview = null;
          this.$refs.photo.value = null; 

          this.$router.push("/customers");
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 422) {
              this.errorList = error.response.data.errors;
            }
          } else {
            console.error("Error", error.message);
          }
        });
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        if (["image/jpeg", "image/png"].includes(file.type)) {
          this.model.customer.photo = file;
          this.photoPreview = URL.createObjectURL(file);
        } else {
          alert("Only JPG and PNG files are allowed.");
          this.$refs.photo.value = "";
          this.model.customer.photo = "";
          this.photoPreview = null;
        }
      }
    },
  },
};
</script>

<style>

</style>

