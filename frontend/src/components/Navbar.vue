<template>
  <nav
    class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm position-relative"
  >
    <div class="container-fluid px-3 px-lg-4">
      <RouterLink class="navbar-brand fw-bold d-flex align-items-center" to="/">
        <i class="pi pi-book me-2"></i>
        <span class="d-none d-sm-inline">Biblioteca</span>
        <span class="d-inline d-sm-none">Bib</span>
      </RouterLink>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContent"
        aria-controls="navbarContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
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
                active-class="active"
              >
                <i class="pi pi-plus me-2"></i>
                <span>Crear Préstamo</span>
              </RouterLink>
            </li>

            <li class="nav-item">
              <RouterLink
                class="nav-link d-flex align-items-center"
                to="/prestamo/consultar"
                active-class="active"
              >
                <i class="pi pi-search me-2"></i>
                <span>Consultar Préstamo</span>
              </RouterLink>
            </li>
          </template>
        </ul>

        <div
          class="d-none d-lg-block position-absolute start-50 translate-middle-x text-center"
          style="pointer-events: none"
        >
          <span class="navbar-text text-white fw-semibold small">
            Prueba Técnica – Indigo Technologies S.A.S
          </span>
        </div>

        <template v-if="auth.token">
          <div class="d-grid d-lg-block mt-2 mt-lg-0">
            <button
              class="btn btn-light btn-sm px-3 fw-semibold d-flex align-items-center justify-content-center"
              @click="logout"
            >
              <i class="pi pi-sign-out me-2"></i>
              <span>Cerrar Sesión</span>
            </button>
          </div>
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
.navbar {
  min-height: 60px;
}

.navbar-brand {
  font-size: 1.25rem;
}

.navbar-brand i {
  font-size: 1.5rem;
}

.nav-link {
  padding: 0.5rem 1rem;
  transition: background-color 0.3s ease;
  border-radius: 0.375rem;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.nav-link.active {
  background-color: rgba(255, 255, 255, 0.2);
  font-weight: 600;
}

.nav-link i {
  font-size: 1.1rem;
}

.btn-light {
  transition: all 0.3s ease;
}

.btn-light:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

@media (max-width: 991.98px) {
  .navbar-nav {
    padding: 0.5rem 0;
  }

  .nav-item {
    margin: 0.25rem 0;
  }

  .nav-link {
    padding: 0.75rem 1rem;
  }

  .btn-light {
    width: 100%;
    margin-top: 0.5rem;
  }
}

@media (min-width: 768px) and (max-width: 991.98px) {
  .navbar-text {
    font-size: 0.875rem;
  }
}

@media (max-width: 575.98px) {
  .navbar-brand {
    font-size: 1.1rem;
  }

  .navbar-brand i {
    font-size: 1.3rem;
  }
}
</style>
