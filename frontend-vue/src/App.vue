<template>
  <header>
    <div class="wrapper">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <RouterLink class="navbar-brand" to="/">Navbar</RouterLink>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <RouterLink class="nav-link" :class="{ active: isActive('/customers') }" to="/customers">Customers</RouterLink>
              </li>                            
              <li class="nav-item">
                <RouterLink class="nav-link" :class="{ active: isActive('/arrayinput') }" to="/arrayinput">Array Input</RouterLink>
              </li>                              
            </ul>            
          </div>
        </div>
      </nav>
    </div>
    <RouterView />
  </header>
</template>

<script setup>
import { useRoute, RouterLink, RouterView } from 'vue-router';

const route = useRoute();

const isActive = (path) => {
  return route.path === path;
};
</script>

<style scoped>
.nav-link.active {
  font-weight: bold;
  color: #fff; /* Sesuaikan warna sesuai keinginan */
}
</style>
