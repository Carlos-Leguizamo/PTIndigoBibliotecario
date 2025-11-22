import { defineStore } from "pinia";
import * as authApi from "../api/auth";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || null
  }),

  actions: {
    async login(email, password) {
      const res = await authApi.login({ email, password });
      this.token = res.data.token;
      localStorage.setItem("token", this.token);
      await this.getUser();
    },

    async register(data) {
      await authApi.register(data);
    },

    async getUser() {
      const res = await authApi.getUser();
      this.user = res.data;
    },

    logout() {
      this.user = null;
      this.token = null;
      localStorage.removeItem("token");
    }
  }
});
