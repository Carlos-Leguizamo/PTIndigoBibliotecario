<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow">
          <div class="card-body p-4">
            <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>

            <form @submit.prevent="login">
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
                  id="password"
                  placeholder="••••••••"
                  required
                />
              </div>

              <div class="d-grid">
                <button
                  type="submit"
                  class="btn btn-primary"
                  :disabled="isLoading"
                >
                  <span
                    v-if="isLoading"
                    class="spinner-border spinner-border-sm me-2"
                  ></span>
                  {{ isLoading ? "Ingresando..." : "Ingresar" }}
                </button>
              </div>
            </form>

            <div class="text-center mt-3">
              <p class="mb-0">
                ¿No tienes una cuenta?
                <a href="/register" class="text-decoration-none"
                  >Regístrate aquí</a
                >
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../../store/auth";
import Swal from "sweetalert2";

const email = ref("");
const password = ref("");
const isLoading = ref(false);

const auth = useAuthStore();

async function login() {
  isLoading.value = true;

  try {
    await auth.login(email.value, password.value);

    await Swal.fire({
      icon: "success",
      title: "¡Bienvenido!",
      text: "Inicio de sesión exitoso",
      timer: 1500,
      showConfirmButton: false,
    });

    window.location.href = "/prestamo/crear";
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Login incorrecto",
      text: "Email o contraseña incorrectos",
      confirmButtonColor: "#0d6efd",
    });
  } finally {
    isLoading.value = false;
  }
}
</script>
