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
```

### Configuración de la Base de Datos

#### Crear la base de datos

```sql
CREATE DATABASE prueba_tecnica;
```

#### Variables de entorno (.env)

Configura el archivo `.env` con los siguientes datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prueba_tecnica
DB_USERNAME=root
DB_PASSWORD=
```

#### Crear archivo .env

**En Linux/Mac:**

```bash
cp .env.example .env
php artisan key:generate
```

**En Windows (Command Prompt):**

```cmd
copy .env.example .env
php artisan key:generate
```

**En Windows (PowerShell):**

```powershell
Copy-Item .env.example -Destination .env
php artisan key:generate
```

#### Ejecutar migraciones y seeders

```bash
php artisan migrate:fresh --seed
```

---

## 🚀 Instalación Frontend

Desde la carpeta frontend, ejecuta:

```bash
npx serve
```

El frontend estará disponible en `http://localhost:3000` (o el puerto que asigne `serve`)

---

## 3️⃣ CONOCIMIENTOS DE LÓGICA DE PROGRAMACIÓN

### Matriz CRUD de Pacientes

Este proyecto implementa una matriz CRUD completa para la gestión de pacientes con las siguientes características:

- **Crear**: Agregar nuevos pacientes con validación de datos
- **Leer**: Listar todos los pacientes con relaciones
- **Actualizar**: Modificar datos de pacientes existentes
- **Eliminar**: Borrar registros de pacientes
- **Foto del paciente**: Soporte opcional para carga de imágenes

### Estructura de Datos

El proyecto utiliza las siguientes tablas con relaciones por llaves foráneas:

```
departamentos (id, nombre)
municipios (id, departamento_id, nombre)
tipos_documento (id, nombre)
genero (id, nombre)
paciente (
  id, tipo_documento_id, numero_documento,
  nombre1, nombre2, apellido1, apellido2,
  genero_id, departamento_id, municipio_id, correo
)
```

### Base de Datos

#### Migraciones Incluidas

El proyecto incluye todas las migraciones necesarias para:

- Crear las tablas principales (departamentos, municipios, tipos_documento, genero, pacientes)
- Establecer relaciones con llaves foráneas
- Crear tabla de usuarios para autenticación

Las migraciones se encuentran en `pacientes-api/database/migrations/`

#### Seeders Incluidos

El proyecto incluye seeders con los siguientes datos de prueba:

**Departamentos**: 5 registros

- Antioquia
- Cundinamarca
- Valle del Cauca
- Atlántico
- Santander

**Municipios**: 2 registros por cada departamento (total: 10 registros)

**Tipos de Documento**: 2 registros

- CC
- TI

**Géneros**: Registros de género masculino y femenino

**Usuario Administrador**:

- **Email**: admin@admin.com
- **Contraseña**: 1234567890

**Pacientes**: 5 registros de prueba con datos completos

Los seeders se encuentran en `pacientes-api/database/seeders/`

### Instalación Completa

Después de configurar el `.env`, ejecuta:

```bash
php artisan migrate:fresh --seed
```

Este comando:

1. Elimina todas las tablas existentes
2. Ejecuta todas las migraciones para crear la estructura
3. Ejecuta los seeders para poblar las tablas con datos de prueba

---

## 🔐 Autenticación

El sistema utiliza **JWT (JSON Web Tokens)** para la autenticación:

- **Backend**: Laravel con tymon/jwt-auth
- **Login**: Credenciales de usuario administrador (email: admin@admin.com, contraseña: 1234567890)
- **Token**: Se genera al autenticarse y se incluye en cada solicitud posterior
