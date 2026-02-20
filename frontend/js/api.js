const API_BASE = "http://127.0.0.1:8000/api";

// Cliente HTTP con manejo de token
const api = (function () {
  function getToken() {
    return localStorage.getItem("token");
  }

  async function request(endpoint, options = {}) {
    const token = getToken();
    const res = await fetch(`${API_BASE}${endpoint}`, {
      ...options,
      headers: {
        "Content-Type": "application/json",
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
        ...options.headers,
      },
    });

    // Si la respuesta es 401 (no autorizado), lanzamos error y quien llame puede manejar logout
    if (res.status === 401) {
      throw { status: 401, message: "Sesión expirada" };
    }

    if (!res.ok) {
      const errorData = await res.json().catch(() => ({}));
      throw {
        status: res.status,
        message: errorData.message || "Error en la petición",
      };
    }

    return res.json();
  }

  // Métodos públicos
  return {
    login: (credentials) => {
      return fetch(`${API_BASE}/login`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(credentials),
      }).then(async (res) => {
        if (!res.ok) {
          const error = await res.json().catch(() => ({}));
          throw new Error(error.message || "Error de login");
        }
        return res.json();
      });
    },

    getPacientes: (page = 1, q = "") => {
      return request(`/pacientes?page=${page}&q=${encodeURIComponent(q)}`);
    },

    getPaciente: (id) => {
      return request(`/pacientes/${id}`);
    },

    createPaciente: (data) => {
      return request("/pacientes", {
        method: "POST",
        body: JSON.stringify(data),
      });
    },

    updatePaciente: (id, data) => {
      return request(`/pacientes/${id}`, {
        method: "PUT",
        body: JSON.stringify(data),
      });
    },

    deletePaciente: (id) => {
      return request(`/pacientes/${id}`, { method: "DELETE" });
    },
  };
})();
