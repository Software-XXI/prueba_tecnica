# 🏥 Prueba Técnica – Sistema de Gestión de Pacientes

Este proyecto corresponde a la prueba técnica para el cargo de desarrollador.  
Incluye una API RESTful en Laravel con autenticación JWT y un frontend en HTML/JS para la gestión de pacientes.

---

## 📌 Objetivo

Desarrollar una matriz CRUD para el listado de pacientes, respetando las siguientes tablas y relaciones:

- departamentos (id, nombre)
- municipios (id, departamento_id, nombre)
- tipos_documento (id, nombre)
- generos (id, nombre)
- pacientes (
  id, tipo_documento_id, numero_documento,
  nombre1, nombre2, apellido1, apellido2,
  genero_id, departamento_id, municipio_id, correo
  )

---

## 🛠️ Tecnologías

### Backend

- PHP 8.x
- Laravel
- MySQL
- JWT Auth (tymon/jwt-auth)
- PHPUnit (tests)

### Frontend

- HTML
- CSS (Bootstrap)
- JavaScript (fetch API)

---

## 🚀 Instalación Backend

```bash
git clone <repo>
cd pacientes-api
composer install
cp .env.example .env
php artisan key:generate
```
