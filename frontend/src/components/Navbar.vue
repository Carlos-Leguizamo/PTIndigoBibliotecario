<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <RouterLink class="navbar-brand fw-bold d-flex align-items-center" to="/">
        <i class="pi pi-book me-2"></i>
        Biblioteca
      </RouterLink>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContent"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <template v-if="auth.token">
            <li class="nav-item">
              <RouterLink
                class="nav-link d-flex align-items-center"
                to="/prestamo/crear"
              >
                <i class="pi pi-plus me-1"></i>
                Crear Préstamo
              </RouterLink>
            </li>

            <li class="nav-item">
              <RouterLink
                class="nav-link d-flex align-items-center"
                to="/prestamo/consultar"
              >
                <i class="pi pi-search me-1"></i>
                Consultar Préstamo
              </RouterLink>
            </li>
          </template>
        </ul>
        <span class="navbar-text text-white fw-semibold me-6">
          Prueba Técnica – Indigo Technologies S.A.S
        </span>

        <template v-if="auth.token">
          <button
            class="btn btn-light btn-sm px-3 fw-semibold d-flex align-items-center"
            @click="logout"
          >
            <i class="pi pi-sign-out me-1"></i>
            Cerrar Sesión
          </button>
        </template>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useAuthStore } from "../store/auth";
import { useRouter } from "vue-router";

const auth = useAuthStore();
const router = useRouter();

function logout() {
  auth.logout();
  router.push("/login");
}
</script>

<style scoped>
.navbar-brand i {
  font-size: 1.4rem;
}

.nav-link i {
  font-size: 1rem;
}
</style>
