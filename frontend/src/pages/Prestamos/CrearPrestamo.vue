<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-5 mb-4">
        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="bi bi-book me-2"></i>Crear Préstamo</h3>
          </div>
          <div class="card-body p-4">
            <form @submit.prevent="crear">
              <div class="mb-3">
                <label for="isbn" class="form-label fw-semibold">
                  <i class="bi bi-upc-scan me-1"></i>ISBN del Libro
                </label>
                <input
                  v-model="isbn"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': errors.isbn }"
                  id="isbn"
                  placeholder="Ej: 978-3-16-148410-0"
                  required
                />
                <div v-if="errors.isbn" class="invalid-feedback">
                  {{ errors.isbn }}
                </div>
              </div>

              <div class="mb-3">
                <label for="identificacion" class="form-label fw-semibold">
                  <i class="bi bi-person-badge me-1"></i>Identificación del
                  Usuario
                </label>
                <input
                  v-model="identificacion"
                  type="text"
                  class="form-control"
                  :class="{ 'is-invalid': errors.identificacion }"
                  id="identificacion"
                  placeholder="Ej: 1234567890"
                  required
                />
                <div v-if="errors.identificacion" class="invalid-feedback">
                  {{ errors.identificacion }}
                </div>
              </div>

              <div class="mb-4">
                <label for="tipo" class="form-label fw-semibold">
                  <i class="bi bi-people me-1"></i>Tipo de Usuario
                </label>
                <select
                  v-model="tipo"
                  class="form-select"
                  :class="{ 'is-invalid': errors.tipo }"
                  id="tipo"
                  required
                >
                  <option disabled value="">
                    Selecciona el tipo de usuario
                  </option>
                  <option :value="1">Afiliado</option>
                  <option :value="2">Empleado</option>
                  <option :value="3">Invitado</option>
                </select>
                <div v-if="errors.tipo" class="invalid-feedback">
                  {{ errors.tipo }}
                </div>
              </div>

              <div class="d-grid">
                <button
                  type="submit"
                  class="btn btn-primary btn-lg"
                  :disabled="isLoading"
                >
                  <span
                    v-if="isLoading"
                    class="spinner-border spinner-border-sm me-2"
                  ></span>
                  <i v-else class="bi bi-check-circle me-2"></i>
                  {{ isLoading ? "Procesando..." : "Crear Préstamo" }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card shadow">
          <div
            class="card-header bg-success text-white d-flex justify-content-between align-items-center flex-wrap"
          >
            <h3 class="mb-0">
              <i class="bi bi-list-ul me-2"></i>Préstamos Registrados
            </h3>
            <div class="d-flex gap-2 mt-2 mt-md-0">
              <button
                @click="toggleVista"
                class="btn btn-light btn-sm"
              >
                <i :class="vistaAgrupada ? 'bi bi-list' : 'bi bi-collection'"></i>
                {{ vistaAgrupada ? 'Ver Lista' : 'Agrupar' }}
              </button>
              <button
                @click="cargarPrestamos"
                class="btn btn-light btn-sm"
                :disabled="isLoadingList"
              >
                <i class="bi bi-arrow-clockwise me-1"></i>
                {{ isLoadingList ? "Cargando..." : "Actualizar" }}
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <div v-if="isLoadingList" class="text-center p-5">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
              </div>
              <p class="mt-3 text-muted">Cargando préstamos...</p>
            </div>

            <div
              v-else-if="!prestamos || prestamos.length === 0"
              class="text-center p-5"
            >
              <i class="bi bi-inbox display-1 text-muted"></i>
              <p class="mt-3 text-muted">No hay préstamos registrados</p>
            </div>

            <div v-else-if="!vistaAgrupada" class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Identificación</th>
                    <th>Tipo Usuario</th>
                    <th>Fecha Devolución</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="prestamo in prestamos" :key="prestamo.id">
                    <td class="fw-semibold">{{ prestamo.id }}</td>
                    <td>{{ prestamo.isbn }}</td>
                    <td>{{ prestamo.identificacionUsuario }}</td>
                    <td>
                      <span
                        class="badge"
                        :class="getTipoBadgeClass(prestamo.tipoUsuario)"
                      >
                        {{ getTipoUsuarioText(prestamo.tipoUsuario) }}
                      </span>
                    </td>
                    <td>
                      <small class="text-muted">
                        <i class="bi bi-calendar-event me-1"></i>
                        {{ formatFecha(prestamo.fechaMaximaDevolucion) }}
                      </small>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div v-else class="p-3">
              <div 
                v-for="(grupo, identificacion) in prestamosAgrupados" 
                :key="identificacion"
                class="mb-3"
              >
                <div class="card border-start border-secondary border-4">
                  <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                      <h6 class="mb-0 fw-bold">
                        <i class="bi bi-person-circle me-2 text-info"></i>
                        Usuario: {{ identificacion }}
                      </h6>
                      <small class="text-muted">
                        <span
                          class="badge"
                          :class="getTipoBadgeClass(grupo[0].tipoUsuario)"
                        >
                          {{ getTipoUsuarioText(grupo[0].tipoUsuario) }}
                        </span>
                      </small>
                    </div>
                    <span class="badge bg-info rounded-pill">
                      {{ grupo.length }} {{ grupo.length === 1 ? 'préstamo' : 'préstamos' }}
                    </span>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-sm mb-0">
                        <thead class="table-light">
                          <tr>
                            <th>ID Préstamo</th>
                            <th>ISBN</th>
                            <th>Fecha Devolución</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="prestamo in grupo" :key="prestamo.id">
                            <td class="fw-semibold">#{{ prestamo.id }}</td>
                            <td>{{ prestamo.isbn }}</td>
                            <td>
                              <small class="text-muted">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ formatFecha(prestamo.fechaMaximaDevolucion) }}
                              </small>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { crearPrestamo, obtenerListadoPrestamos } from "../../api/prestamo";
import Swal from "sweetalert2";

const isbn = ref("");
const identificacion = ref("");
const tipo = ref("");
const errors = ref({});
const isLoading = ref(false);
const isLoadingList = ref(false);
const prestamos = ref([]);
const vistaAgrupada = ref(false);

const prestamosAgrupados = computed(() => {
  const grupos = {};
  prestamos.value.forEach(prestamo => {
    const id = prestamo.identificacionUsuario;
    if (!grupos[id]) {
      grupos[id] = [];
    }
    grupos[id].push(prestamo);
  });
  return Object.fromEntries(
    Object.entries(grupos).sort((a, b) => b[1].length - a[1].length)
  );
});

onMounted(() => {
  cargarPrestamos();
});

function toggleVista() {
  vistaAgrupada.value = !vistaAgrupada.value;
}

function validateForm() {
  errors.value = {};
  let isValid = true;

  if (!isbn.value.trim()) {
    errors.value.isbn = "El ISBN es obligatorio";
    isValid = false;
  }

  if (!identificacion.value.trim()) {
    errors.value.identificacion = "La identificación es obligatoria";
    isValid = false;
  }

  if (identificacion.value.length > 10) {
    errors.value.identificacion =
      "La identificación no puede exceder 10 caracteres";
    isValid = false;
  }

  if (!tipo.value) {
    errors.value.tipo = "Debes seleccionar un tipo de usuario";
    isValid = false;
  }

  return isValid;
}

async function crear() {
  if (!validateForm()) {
    Swal.fire({
      icon: "warning",
      title: "Campos Incompletos",
      text: "Por favor completa todos los campos requeridos",
      confirmButtonColor: "#0d6efd",
    });
    return;
  }
  isLoading.value = true;
  try {
    const response = await crearPrestamo({
      isbn: isbn.value,
      identificacionUsuario: identificacion.value,
      tipoUsuario: tipo.value,
    });

    await Swal.fire({
      icon: "success",
      title: "¡Préstamo Creado!",
      text: `ID del Préstamo: ${response.data.id}`,
      confirmButtonColor: "#0d6efd",
    });
    
    isbn.value = "";
    identificacion.value = "";
    tipo.value = "";
    errors.value = {};
    await cargarPrestamos();
  } catch (err) {
    Swal.fire({
      icon: "error",
      title: "Error al Crear Préstamo",
      text: err.response?.data?.mensaje || "Error al crear el préstamo",
      confirmButtonColor: "#0d6efd",
    });
  } finally {
    isLoading.value = false;
  }
}

async function cargarPrestamos() {
  isLoadingList.value = true;
  try {
    const response = await obtenerListadoPrestamos();
    prestamos.value = response.data;
  } catch (err) {
    console.error("Error al cargar préstamos:", err);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No se pudieron cargar los préstamos",
      confirmButtonColor: "#0d6efd",
    });
  } finally {
    isLoadingList.value = false;
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
    year: "numeric",
    month: "short",
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

.form-control:focus,
.form-select:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-lg {
  padding: 12px 20px;
  font-weight: 500;
}

.table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
}

.badge {
  font-weight: 500;
  padding: 0.4em 0.8em;
}

.border-4 {
  border-width: 4px !important;
}

.card .card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card .card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

@media (max-width: 767.98px) {
  .card-header h3 {
    font-size: 1.1rem;
  }
  
  .btn-sm {
    font-size: 0.8rem;
    padding: 0.375rem 0.5rem;
  }
}
</style>