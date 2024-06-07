<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h4>Edit Customer</h4>
      </div>
      <div class="card-body">
        <ul
          class="alert alert-warning"
          v-if="Object.keys(errorList).length > 0"
        >
          <li
            class="mb-0 ms-3"
            v-for="(error, index) in errorList"
            :key="index"
          >
            {{ error[0] }}
          </li>
        </ul>
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input
            type="text"
            v-model="model.customer.name"
            class="form-control"
            id="name"
          />
        </div>
        <div class="mb-3">
          <label for="photo" class="form-label">Photo</label>
          <input
            type="file"
            ref="photo"
            @change="handleFileUpload"
            class="form-control"
            id="photo"
            accept="image/jpeg, image/png"
          />
          <div v-if="photoPreview || model.customer.photo" class="mt-2">
            <img
              :src="photoPreview ? photoPreview : model.customer.photo"
              alt="Photo Preview"
              class="img-fluid"
              style="max-height: 200px"
            />
          </div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            v-model="model.customer.email"
            class="form-control"
            id="email"
          />
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input
            type="text"
            v-model="model.customer.phone"
            class="form-control"
            id="phone"
          />
        </div>
        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select
            v-model="model.customer.gender"
            class="form-control"
            id="gender"
          >
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="birth_date" class="form-label">Birth Date</label>
          <input
            type="date"
            v-model="model.customer.birth_date"
            class="form-control"
            id="birth_date"
          />
        </div>
        <div class="mb-3">
          <button type="button" @click="updateCustomer" class="btn btn-primary">
            Save
          </button>
          <button
            type="button"
            @click="deleteCustomer"
            class="btn btn-danger ms-2"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";

export default {
  name: "customerEdit",
  setup() {
    const route = useRoute();
    const router = useRouter();
    const errorList = ref({});
    const model = ref({
      customer: {
        name: "",
        photo: null,
        email: "",
        phone: "",
        gender: "",
        birth_date: "",
      },
    });
    const photoPreview = ref(null);

    const loadCustomer = async () => {
      try {
        const res = await axios.get(
          `http://127.0.0.1:8000/api/customers/${route.params.id}`
        );
        model.value.customer = res.data.customer;
      } catch (error) {
        console.error(error);
      }
    };

    const updateCustomer = async () => {
      let formData = new FormData();      
      if (model.value.customer.photo instanceof File) {
        formData.append("photo", model.value.customer.photo);
      }

      try {
        const res = await axios.put(
          `http://127.0.0.1:8000/api/customers/${route.params.id}/edit`,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
            params: {
              name: model.value.customer.name,
              email: model.value.customer.email,
              phone: model.value.customer.phone,
              gender: model.value.customer.gender,
              birth_date: model.value.customer.birth_date,
            },
          }
        );
        console.log(model.value);
        alert(res.data.message);
        router.push("/customers");
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            errorList.value = error.response.data.errors;
          }
        } else {
          console.error("Error", error.message);
        }
      }
    };

    const deleteCustomer = async () => {
      if (!confirm("Apakah Anda yakin ingin menghapus pelanggan ini?")) {
        return; 
      }

      try {
        const res = await axios.delete(
          `http://127.0.0.1:8000/api/customers/${route.params.id}/delete`
        );
        alert(res.data.message);
        router.push("/customers");
      } catch (error) {
        console.error(error);
      }
    };

    const handleFileUpload = (event) => {
      const file = event.target.files[0];
      if (file) {
        if (["image/jpeg", "image/png"].includes(file.type)) {
          model.value.customer.photo = file;
          photoPreview.value = URL.createObjectURL(file);
        } else {
          alert("Only JPG and PNG files are allowed.");
          event.target.value = "";
          model.value.customer.photo = "";
          photoPreview.value = null;
        }
      }
    };

    loadCustomer();

    return {
      errorList,
      model,
      photoPreview,
      updateCustomer,
      deleteCustomer,
      handleFileUpload,
    };
  },
};
</script>

<style>
</style>
