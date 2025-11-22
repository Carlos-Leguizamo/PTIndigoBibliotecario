import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/Auth/Login.vue";
import Register from "../pages/Auth/Register.vue";
import CrearPrestamo from "../pages/Prestamos/CrearPrestamo.vue";
import ConsultarPrestamo from "../pages/Prestamos/ConsultarPrestamo.vue";
import Home from '../pages/Home.vue'

import { useAuthStore } from "../store/auth";

const routes = [
 {
    path: '/',
    component: Home,
    meta: { guest: true },
  },
  {
    path: "/login",
    component: Login,
    meta: { guest: true }
  },
  {
    path: "/register",
    component: Register,
    meta: { guest: true }
  },
  {
    path: "/prestamo/crear",
    component: CrearPrestamo,
    meta: { auth: true }
  },
  {
    path: "/prestamo/consultar",
    component: ConsultarPrestamo,
    meta: { auth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to) => {
  const auth = useAuthStore();

  if (to.meta.auth && !auth.token) {
    return "/login";
  }
  if (to.meta.guest && auth.token) {
    return "/prestamo/crear";
  }
});

export default router;
