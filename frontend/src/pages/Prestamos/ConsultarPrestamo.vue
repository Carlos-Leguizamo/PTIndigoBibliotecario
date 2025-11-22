<template>
  <div class="card">
    <h2>Consultar Préstamo</h2>

    <div class="form-group">
      <input v-model="idPrestamo" placeholder="ID del préstamo" class="input" />
      <button @click="buscar" class="btn">Buscar</button>
    </div>

    <div v-if="prestamo" class="resultado">
      <h3>Resultado:</h3>
      <pre>{{ prestamo }}</pre>
    </div>

    <div v-if="error" class="error">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { obtenerPrestamo } from "../../api/prestamo";

const idPrestamo = ref("");
const prestamo = ref(null);
const error = ref("");

async function buscar() {
  prestamo.value = null;
  error.value = "";

  if (!idPrestamo.value) {
    error.value = "Debes ingresar un ID";
    return;
  }

  try {
    const r = await obtenerPrestamo(idPrestamo.value);
    prestamo.value = r.data;
  } catch (e) {
    error.value = e.response?.data?.mensaje || "Error al consultar préstamo";
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
  display: flex;
  gap: 10px;
}

.input {
  flex: 1;
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
