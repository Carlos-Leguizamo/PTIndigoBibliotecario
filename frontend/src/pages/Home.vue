<template>
  <div class="container text-center mt-5">
    <i class="pi pi-book mb-4" style="font-size: 120px; color: #0d6efd;"></i>

    <h1 class="display-4 mb-3">Bienvenido a la Biblioteca Virtual</h1>
    <p class="lead mb-4">
      La aplicación está enfocada en gestionar el préstamo de libros a usuarios
      con diferentes tipos de relación con la biblioteca, permitiendo consultar,
      registrar y administrar los préstamos según las reglas establecidas.
    </p>

    <div>
      <RouterLink to="/login" class="btn btn-primary btn-lg me-3"
        >Iniciar Sesión</RouterLink
      >
      <RouterLink to="/register" class="btn btn-outline-primary btn-lg"
        >Registrarse</RouterLink
      >
    </div>
  </div>
</template>

<script setup></script>