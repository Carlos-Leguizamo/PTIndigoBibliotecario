<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h3 class="mb-0">
              <i class="bi bi-search me-2"></i>Consultar Préstamo
            </h3>
          </div>
          <div class="card-body p-4">
            <form @submit.prevent="buscar">
              <div class="row g-3 align-items-end">
                <div class="col-12 col-sm-8">
                  <label for="idPrestamo" class="form-label fw-semibold">
                    <i class="bi bi-hash me-1"></i>ID del Préstamo
                  </label>
                  <input
                    v-model="idPrestamo"
                    type="text"
                    class="form-control form-control-lg"
                    :class="{ 'is-invalid': errorValidacion }"
                    id="idPrestamo"
                    placeholder="Ej: ad2820ad-0453-4642-8120-f236b1e81e31"
                    required
                  />
                  <div v-if="errorValidacion" class="invalid-feedback">
                    {{ errorValidacion }}
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <button
                    type="submit"
                    class="btn btn-primary btn-lg w-100"
                    :disabled="isLoading"
                  >
                    <span
                      v-if="isLoading"
                      class="spinner-border spinner-border-sm me-2"
                    ></span>
                    <i v-else class="bi bi-search me-2"></i>
                    {{ isLoading ? "Buscando..." : "Buscar" }}
                  </button>
                </div>
              </div>
            </form>

            <div v-if="prestamo" class="mt-4">
              <div
                class="alert alert-success border-start border-5 border-success"
              >
                <h5 class="alert-heading d-flex align-items-center">
                  <i class="bi bi-check-circle-fill me-2"></i>
                  Préstamo Encontrado
                </h5>
                <hr />
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="info-item">
                      <small class="text-muted d-block mb-1">
                        <i class="bi bi-key-fill me-1"></i>ID Préstamo
                      </small>
                      <p class="fw-bold mb-0">{{ prestamo.id }}</p>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="info-item">
                      <small class="text-muted d-block mb-1">
                        <i class="bi bi-upc-scan me-1"></i>ISBN
                      </small>
                      <p class="fw-bold mb-0">{{ prestamo.isbn }}</p>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="info-item">
                      <small class="text-muted d-block mb-1">
                        <i class="bi bi-person-badge me-1"></i>Identificación
                        Usuario
                      </small>
                      <p class="fw-bold mb-0">
                        {{ prestamo.identificacionUsuario }}
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="info-item">
                      <small class="text-muted d-block mb-1">
                        <i class="bi bi-people me-1"></i>Tipo de Usuario
                      </small>
                      <span
                        class="badge"
                        :class="getTipoBadgeClass(prestamo.tipoUsuario)"
                      >
                        {{ getTipoUsuarioText(prestamo.tipoUsuario) }}
                      </span>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="info-item">
                      <small class="text-muted d-block mb-1">
                        <i class="bi bi-calendar-event me-1"></i>Fecha Máxima de
                        Devolución
                      </small>
                      <p class="fw-bold mb-0 text-primary">
                        {{ formatFecha(prestamo.fechaMaximaDevolucion) }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div
              v-if="!prestamo && !error && !isLoading && hasSearched"
              class="mt-4"
            >
              <div class="alert alert-light text-center border">
                <i class="bi bi-info-circle display-4 text-muted"></i>
                <p class="mt-3 mb-0 text-muted">No se encontraron resultados</p>
              </div>
            </div>

            <div v-if="error" class="mt-4">
              <div
                class="alert alert-danger border-start border-5 border-danger"
              >
                <h5 class="alert-heading d-flex align-items-center">
                  <i class="bi bi-exclamation-triangle-fill me-2"></i>
                  Error
                </h5>
                <p class="mb-0">{{ error }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mt-4 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">
              <i class="bi bi-lightbulb me-2 text-warning"></i>Consejo
            </h6>
            <p class="card-text small text-muted mb-0">
              Ingresa el ID del préstamo que deseas consultar. Puedes encontrar
              este ID en la lista de préstamos registrados.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { obtenerPrestamo } from "../../api/prestamo";
import Swal from "sweetalert2";

const idPrestamo = ref("");
const prestamo = ref(null);
const error = ref("");
const errorValidacion = ref("");
const isLoading = ref(false);
const hasSearched = ref(false);

async function buscar() {
  prestamo.value = null;
  error.value = "";
  errorValidacion.value = "";
  hasSearched.value = false;

  if (!idPrestamo.value.trim()) {
    errorValidacion.value = "Debes ingresar un ID";
    Swal.fire({
      icon: "warning",
      title: "Campo Requerido",
      text: "Por favor ingresa el ID del préstamo",
      confirmButtonColor: "#0d6efd",
    });
    return;
  }

  isLoading.value = true;

  try {
    const response = await obtenerPrestamo(idPrestamo.value);
    prestamo.value = response.data;
    hasSearched.value = true;

    Swal.fire({
      icon: "success",
      title: "Préstamo Encontrado",
      text: `ID: ${response.data.id}`,
      timer: 2000,
      showConfirmButton: false,
    });
  } catch (err) {
    error.value = err.response?.data?.mensaje || "Error al consultar préstamo";
    hasSearched.value = true;

    Swal.fire({
      icon: "error",
      title: "Préstamo No Encontrado",
      text: error.value,
      confirmButtonColor: "#0d6efd",
    });
  } finally {
    isLoading.value = false;
  }
}

function getTipoUsuarioText(tipo) {
  const tipos = {
    1: "Afiliado",
    2: "Empleado",
    3: "Invitado",
  };
  return tipos[tipo] || "Desconocido";
}

function getTipoBadgeClass(tipo) {
  const clases = {
    1: "bg-primary",
    2: "bg-success",
    3: "bg-warning text-dark",
  };
  return clases[tipo] || "bg-secondary";
}

function formatFecha(fecha) {
  if (!fecha) return "N/A";
  const date = new Date(fecha);
  return date.toLocaleDateString("es-ES", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}
</script>

<style scoped>
.card-header {
  border-bottom: 3px solid rgba(0, 0, 0, 0.1);
}

.form-label {
  color: #495057;
  font-size: 0.95rem;
}

.form-control:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.info-item {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 0.375rem;
  height: 100%;
}

.badge {
  font-weight: 500;
  padding: 0.5em 1em;
  font-size: 0.9rem;
}

.btn-lg {
  padding: 12px 20px;
  font-weight: 500;
}

.alert {
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 575.98px) {
  .card-body {
    padding: 1.5rem 1rem !important;
  }

  .info-item {
    padding: 0.75rem;
  }

  .btn-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
  }
}
</style>
