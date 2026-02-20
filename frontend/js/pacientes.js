(function () {
  // Si no existe la tabla de pacientes, salimos (no estamos en dashboard)
  if (!document.getElementById("tablaPacientes")) return;

  // Estado
  let currentPage = 1;
  let lastPage = 1;
  let searchQuery = "";
  let editId = null;

  // Utilidades
  const debounce = (fn, delay) => {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => fn(...args), delay);
    };
  };

  // Elementos del DOM
  const $ = (id) => document.getElementById(id);

  // Renderizar tabla
  function renderPacientes(data) {
    const tbody = $("tablaPacientes");
    if (!tbody) return;

    tbody.innerHTML = "";

    if (!data.data || data.data.length === 0) {
      tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No hay pacientes para mostrar</td></tr>`;
      return;
    }

    data.data.forEach((p) => {
      tbody.innerHTML += `
        <tr>
          <td>${p.id}</td>
          <td>${p.nombre1} ${p.apellido1}</td>
          <td>${p.correo}</td>
          <td>
            <button class="btn btn-sm btn-primary me-2" onclick="pacientes.startEdit(${p.id})">Editar</button>
            <button class="btn btn-sm btn-danger" onclick="pacientes.eliminar(${p.id})">🗑️ Eliminar</button>
          </td>
        </tr>
      `;
    });
  }

  // Actualizar info de paginación
  function updatePagination(data) {
    lastPage = data.last_page;
    const pageInfo = $("pageInfo");
    if (pageInfo) {
      pageInfo.textContent = `Página ${data.current_page} de ${data.last_page}`;
    }
    const recordsInfo = $("recordsInfo");
    if (recordsInfo) {
      recordsInfo.innerHTML = `Mostrando <strong>${data.from || 0}-${data.to || 0}</strong> de <strong>${data.total}</strong> pacientes`;
    }
    // Actualizar estado de botones de paginación
    const btnAnterior = $("btnAnterior");
    const btnSiguiente = $("btnSiguiente");
    if (btnAnterior) btnAnterior.disabled = currentPage <= 1;
    if (btnSiguiente) btnSiguiente.disabled = currentPage >= lastPage;
  }

  // Cargar pacientes
  async function cargarPacientes() {
    try {
      const data = await api.getPacientes(currentPage, searchQuery);
      renderPacientes(data);
      updatePagination(data);
    } catch (error) {
      if (error.status === 401) {
        auth.logout(); // api ya lanzó 401, pero auth.logout redirige
      } else {
        console.error("Error al cargar pacientes:", error);
        alert(error.message || "Error al cargar pacientes");
      }
    }
  }

  // Eliminar paciente
  async function eliminar(id) {
    if (!confirm("¿Eliminar este paciente?")) return;
    try {
      await api.deletePaciente(id);
      alert("✅ Paciente eliminado exitosamente");
      cargarPacientes();
    } catch (error) {
      if (error.status === 401) auth.logout();
      else alert(error.message || "Error al eliminar");
    }
  }

  // Iniciar edición
  async function startEdit(id) {
    try {
      const data = await api.getPaciente(id);
      $("nombre1").value = data.nombre1 || "";
      $("apellido1").value = data.apellido1 || "";
      $("correo").value = data.correo || "";
      editId = id;
      $("submitBtn").textContent = "Actualizar Paciente";
      $("cancelEditBtn").classList.remove("d-none");
      window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (error) {
      if (error.status === 401) auth.logout();
      else alert(error.message || "No se pudo cargar el paciente");
    }
  }

  // Configurar formulario
  function setupForm() {
    const form = $("pacienteForm");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const nombre1 = $("nombre1").value.trim();
      const apellido1 = $("apellido1").value.trim();
      const correo = $("correo").value.trim();

      // Validaciones (usamos las mismas que antes)
      const errors = [];
      if (
        !nombre1 ||
        nombre1.length < 2 ||
        !/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/.test(nombre1)
      )
        errors.push("nombre1Error");
      if (
        !apellido1 ||
        apellido1.length < 2 ||
        !/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/.test(apellido1)
      )
        errors.push("apellido1Error");
      if (!correo || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo))
        errors.push("correoError");

      // Limpiar errores previos
      document.querySelectorAll("small[id$='Error']").forEach((el) => {
        el.textContent = "";
        el.classList.add("d-none");
      });

      if (errors.length > 0) {
        errors.forEach((id) => {
          const el = $(id);
          if (el) {
            el.textContent = "Campo inválido";
            el.classList.remove("d-none");
          }
        });
        return;
      }

      const payload = {
        nombre1,
        apellido1,
        correo,
        tipo_documento_id: 1,
        numero_documento: Date.now().toString(),
        genero_id: 1,
        departamento_id: 1,
        municipio_id: 1,
      };

      try {
        if (editId) {
          await api.updatePaciente(editId, payload);
          alert("✅ Paciente actualizado");
          editId = null;
          $("submitBtn").textContent = "Crear Paciente";
          $("cancelEditBtn").classList.add("d-none");
        } else {
          await api.createPaciente(payload);
          alert("✅ Paciente creado");
        }
        form.reset();
        cargarPacientes();
      } catch (error) {
        if (error.status === 401) auth.logout();
        else alert(error.message || "Error al guardar");
      }
    });

    $("cancelEditBtn")?.addEventListener("click", () => {
      editId = null;
      form.reset();
      $("cancelEditBtn").classList.add("d-none");
      $("submitBtn").textContent = "Crear Paciente";
    });
  }

  // Inicializar
  function init() {
    cargarPacientes();

    const searchInput = $("busqueda");
    if (searchInput) {
      searchInput.addEventListener(
        "input",
        debounce(() => {
          searchQuery = searchInput.value;
          currentPage = 1;
          cargarPacientes();
        }, 300),
      );
    }

    setupForm();

    // Exponer funciones necesarias globalmente para los botones inline
    window.pacientes = {
      startEdit,
      eliminar,
    };
    window.siguiente = () => {
      if (currentPage < lastPage) {
        currentPage++;
        cargarPacientes();
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    };
    window.anterior = () => {
      if (currentPage > 1) {
        currentPage--;
        cargarPacientes();
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    };
    window.logout = auth.logout;
  }

  // Ejecutar cuando el DOM esté listo
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
