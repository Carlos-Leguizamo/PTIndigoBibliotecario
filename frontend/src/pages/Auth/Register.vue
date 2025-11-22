<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow">
          <div class="card-body p-4">
            <h2 class="card-title text-center mb-4">Registro</h2>
            
            <form @submit.prevent="register">
              <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input 
                  v-model="name" 
                  type="text" 
                  class="form-control" 
                  id="name"
                  placeholder="Tu nombre completo"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                  v-model="email" 
                  type="email" 
                  class="form-control" 
                  id="email"
                  placeholder="correo@ejemplo.com"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input 
                  v-model="password" 
                  type="password" 
                  class="form-control" 
                  :class="{ 'is-invalid': passwordError }"
                  id="password"
                  placeholder="••••••••"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                <input 
                  v-model="confirmPassword" 
                  type="password" 
                  class="form-control" 
                  :class="{ 'is-invalid': passwordError }"
                  id="confirmPassword"
                  placeholder="••••••••"
                  required
                />
                <div v-if="passwordError" class="invalid-feedback">
                  Las contraseñas no coinciden
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary" :disabled="isLoading">
                  <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
                  {{ isLoading ? 'Registrando...' : 'Registrar' }}
                </button>
              </div>
            </form>

            <div class="text-center mt-3">
              <p class="mb-0">
                ¿Ya tienes una cuenta? 
                <a href="/login" class="text-decoration-none">Inicia sesión aquí</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useAuthStore } from "../../store/auth";
import Swal from "sweetalert2";

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");
const isLoading = ref(false);

const auth = useAuthStore();

const passwordError = computed(() => {
  if (!confirmPassword.value) return false;
  return password.value !== confirmPassword.value;
});

async function register() {
  if (password.value !== confirmPassword.value) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Las contraseñas no coinciden",
      confirmButtonColor: "#0d6efd"
    });
    return;
  }
  if (password.value.length < 6) {
    Swal.fire({
      icon: "warning",
      title: "Contraseña débil",
      text: "La contraseña debe tener al menos 6 caracteres",
      confirmButtonColor: "#0d6efd"
    });
    return;
  }
  isLoading.value = true;
  try {
    await auth.register({ 
      name: name.value, 
      email: email.value, 
      password: password.value,
      password_confirmation: confirmPassword.value
    });
    
    await Swal.fire({
      icon: "success",
      title: "¡Registro exitoso!",
      text: "Usuario registrado correctamente",
      confirmButtonColor: "#0d6efd"
    });

    window.location.href = "/login";
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error al registrarse",
      text: error.response?.data?.message || "Ocurrió un error. Intenta nuevamente.",
      confirmButtonColor: "#0d6efd"
    });
  } finally {
    isLoading.value = false;
  }
}
</script>