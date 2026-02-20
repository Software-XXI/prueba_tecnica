// Depende de api (ya cargado)
const auth = (function () {
  // Funciones internas
  function setToken(token) {
    if (token) localStorage.setItem("token", token);
    else localStorage.removeItem("token");
  }

  function getToken() {
    return localStorage.getItem("token");
  }

  function isAuthenticated() {
    return !!getToken();
  }

  function logout() {
    setToken(null);
    window.location.href = "./index.html";
  }

  // Inicializar listeners del login si estamos en la página de login
  function initLogin() {
    const loginForm = document.getElementById("loginForm");
    if (!loginForm) return;

    loginForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value;

      if (!email || !password) {
        showError("Por favor completa todos los campos");
        return;
      }

      try {
        const data = await api.login({ email, password });
        setToken(data.access_token);
        setTimeout(() => {
          window.location.href = "./dashboard.html";
        }, 200);
      } catch (error) {
        showError(error.message);
      }
    });
  }

  function showError(message) {
    const errorEl = document.getElementById("error");
    if (errorEl) {
      errorEl.innerText = message;
      errorEl.classList.add("show");
    }
  }

  // Inicializar protección de rutas
  function protectRoute() {
    if (
      window.location.pathname.includes("dashboard.html") &&
      !isAuthenticated()
    ) {
      window.location.href = "./index.html";
    }
  }

  // Public API
  return {
    init: () => {
      protectRoute();
      initLogin();
    },
    logout,
    isAuthenticated,
    getToken,
  };
})();

// Inicializar auth cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  auth.init();
});
