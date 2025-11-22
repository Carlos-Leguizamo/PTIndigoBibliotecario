import api from "./apiClient";

export const crearPrestamo = (data) => {
  return api.post("/prestamo", data);
};
export const obtenerPrestamo = (id) => {
  return api.get(`/prestamo/${id}`);
};
