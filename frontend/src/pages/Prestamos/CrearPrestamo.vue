<template>
  <div class="card">
    <h2>Crear Préstamo</h2>

    <div class="form-group">
      <input v-model="isbn" placeholder="ISBN del libro" class="input" />
    </div>

    <div class="form-group">
      <input
        v-model="identificacion"
        placeholder="Identificación del usuario"
        class="input"
      />
    </div>

    <div class="form-group">
      <select v-model="tipo" class="input">
        <option disabled value="">Selecciona Tipo de Usuario</option>
        <option :value="1">Afiliado</option>
        <option :value="2">Empleado</option>
        <option :value="3">Invitado</option>
      </select>
    </div>

    <button @click="crear" class="btn">Crear</button>

    <div v-if="resultado" class="resultado">
      <h3>Préstamo creado:</h3>
      <pre>{{ resultado }}</pre>
    </div>

    <div v-if="error" class="error">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { crearPrestamo } from "../../api/prestamo";

const isbn = ref("");
const identificacion = ref("");
const tipo = ref("");
const resultado = ref(null);
const error = ref("");

async function crear() {
  resultado.value = null;
  error.value = "";

  if (!isbn.value || !identificacion.value || !tipo.value) {
    error.value = "Todos los campos son obligatorios";
    return;
  }

  try {
    const response = await crearPrestamo({
      isbn: isbn.value,
      identificacionUsuario: identificacion.value,
      tipoUsuario: tipo.value,
    });

    resultado.value = response.data;
  } catch (err) {
    error.value =
      err.response?.data?.mensaje || "Error al crear el préstamo";
  }
}
</script>

<style scoped>
.card {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  max-width: 500px;
}

.form-group {
  margin-bottom: 12px;
}

.input {
  width: 100%;
  padding: 10px;
  border: 1px solid #aaa;
  border-radius: 4px;
}

.btn {
  background: #3f51b5;
  border: none;
  padding: 10px 15px;
  color: white;
  cursor: pointer;
  border-radius: 4px;
}

.btn:hover {
  background: #303f9f;
}

.resultado {
  margin-top: 20px;
  background: #eef;
  padding: 10px;
  border-radius: 4px;
}

.error {
  margin-top: 10px;
  color: red;
}
</style>
