# Laravel User Management API

REST API desarrollada con **Laravel 12** para la gestión de usuarios, implementando operaciones CRUD completas con almacenamiento en memoria.

---

## Tabla de contenidos

- [Descripción general](#descripción-general)
- [Requisitos](#requisitos)
- [Instalación y ejecución](#instalación-y-ejecución)
- [Documentación de rutas (Artisan)](#documentación-de-rutas-artisan)
- [Endpoints](#endpoints)
- [Estructura de peticiones y respuestas](#estructura-de-peticiones-y-respuestas)
- [Códigos de estado](#códigos-de-estado)
- [Ejemplos de uso](#ejemplos-de-uso)

---

## Descripción general

Esta API expone un conjunto de endpoints RESTful para administrar una colección de usuarios. Cada usuario tiene los campos `id`, `name`, `email` y `age`. Los datos se almacenan en memoria (sin base de datos persistente), lo que significa que se reinician al reiniciar el servidor; la API incluye tres usuarios precargados como datos de prueba: **Alice**, **Bob** y **Charlie**.

**Stack tecnológico:**

| Componente | Versión |
|---|---|
| PHP | ^8.2 |
| Laravel | ^12.0 |
| Motor de almacenamiento | En memoria (estático) |

**URL base:** `http://localhost:8000/api`

---

## Requisitos

- PHP 8.2 o superior
- Composer
- Laravel CLI (`composer global require laravel/installer`)

---

## Instalación y ejecución

```bash
# Clonar el repositorio
git clone <url-del-repositorio>
cd laravel-api

# Instalar dependencias
composer install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Iniciar el servidor de desarrollo
php artisan serve
```

El servidor quedará disponible en `http://localhost:8000`.

---

## Documentación de rutas (Artisan)

Laravel incluye el comando `route:list`, herramienta propia del framework que genera un listado completo de todos los endpoints registrados en la aplicación:

```bash
php artisan route:list
```

Salida esperada:

```
GET|HEAD   api/              Bienvenida
GET|HEAD   api/users         UserController@index
POST       api/users         UserController@store
GET|HEAD   api/users/{id}    UserController@show
PUT|PATCH  api/users/{id}    UserController@update
DELETE     api/users/{id}    UserController@destroy
```

Para filtrar solo las rutas de la API:

```bash
php artisan route:list --path=api
```

---

## Endpoints

### Resumen

| Método | Ruta | Descripción |
|---|---|---|
| `GET` | `/api/` | Bienvenida / estado de la API |
| `GET` | `/api/users` | Obtener todos los usuarios |
| `GET` | `/api/users/{id}` | Obtener un usuario por ID |
| `POST` | `/api/users` | Crear un nuevo usuario |
| `PUT` | `/api/users/{id}` | Actualizar un usuario existente |
| `DELETE` | `/api/users/{id}` | Eliminar un usuario |

---

### `GET /api/`

Retorna información básica sobre la API.

**Respuesta exitosa `200 OK`:**
```json
{
  "message": "API de usuarios con Laravel",
  "version": "1.0"
}
```

---

### `GET /api/users`

Retorna la lista completa de usuarios.

**Respuesta exitosa `200 OK`:**
```json
[
  {
    "id": 1,
    "name": "Alice",
    "email": "alice@example.com",
    "age": 30
  },
  {
    "id": 2,
    "name": "Bob",
    "email": "bob@example.com",
    "age": 25
  },
  {
    "id": 3,
    "name": "Charlie",
    "email": "charlie@example.com",
    "age": 35
  }
]
```

---

### `GET /api/users/{id}`

Retorna un usuario específico por su ID.

**Parámetros de ruta:**

| Parámetro | Tipo | Descripción |
|---|---|---|
| `id` | integer | ID único del usuario |

**Respuesta exitosa `200 OK`:**
```json
{
  "id": 1,
  "name": "Alice",
  "email": "alice@example.com",
  "age": 30
}
```

**Error `404 Not Found`:**
```json
{
  "error": "Usuario no encontrado"
}
```

---

### `POST /api/users`

Crea un nuevo usuario.

**Headers requeridos:**
```
Content-Type: application/json
Accept: application/json
```

**Cuerpo de la petición:**

| Campo | Tipo | Requerido | Descripción |
|---|---|---|---|
| `name` | string | Sí | Nombre completo del usuario |
| `email` | string | Sí | Correo electrónico del usuario |
| `age` | integer | Sí | Edad del usuario |

```json
{
  "name": "Diana",
  "email": "diana@example.com",
  "age": 28
}
```

**Respuesta exitosa `201 Created`:**
```json
{
  "id": 4,
  "name": "Diana",
  "email": "diana@example.com",
  "age": 28
}
```

**Error de validación `400 Bad Request`:**
```json
{
  "error": "Datos inválidos",
  "details": {
    "name": ["The name field is required."],
    "email": ["The email field is required."],
    "age": ["The age field is required."]
  }
}
```

---

### `PUT /api/users/{id}`

Actualiza los datos de un usuario existente. Solo se actualizan los campos enviados.

**Parámetros de ruta:**

| Parámetro | Tipo | Descripción |
|---|---|---|
| `id` | integer | ID único del usuario |

**Headers requeridos:**
```
Content-Type: application/json
Accept: application/json
```

**Cuerpo de la petición (campos opcionales):**
```json
{
  "name": "Alice Updated",
  "age": 31
}
```

**Respuesta exitosa `200 OK`:**
```json
{
  "id": 1,
  "name": "Alice Updated",
  "email": "alice@example.com",
  "age": 31
}
```

**Error `404 Not Found`:**
```json
{
  "error": "Usuario no encontrado"
}
```

---

### `DELETE /api/users/{id}`

Elimina un usuario por su ID.

**Parámetros de ruta:**

| Parámetro | Tipo | Descripción |
|---|---|---|
| `id` | integer | ID único del usuario |

**Respuesta exitosa `200 OK`:**
```json
{
  "message": "Usuario eliminado correctamente"
}
```

**Error `404 Not Found`:**
```json
{
  "error": "Usuario no encontrado"
}
```

---

## Estructura de peticiones y respuestas

### Modelo de usuario

```json
{
  "id":    1,
  "name":  "string",
  "email": "string",
  "age":   0
}
```

### Respuesta de error genérica

```json
{
  "error": "Descripción del error"
}
```

### Ruta no registrada

Cualquier ruta no definida retorna `404`:
```json
{
  "error": "Ruta no encontrada"
}
```

---

## Códigos de estado

| Código | Significado | Cuándo se usa |
|---|---|---|
| `200 OK` | Éxito | GET, PUT y DELETE exitosos |
| `201 Created` | Recurso creado | POST exitoso |
| `400 Bad Request` | Petición inválida | Fallo de validación en POST |
| `404 Not Found` | No encontrado | Usuario o ruta inexistente |

---

## Ejemplos de uso

Los siguientes ejemplos usan **cURL**. También pueden ejecutarse con Postman o cualquier cliente HTTP.

### Obtener todos los usuarios

```bash
curl -X GET http://localhost:8000/api/users \
  -H "Accept: application/json"
```

### Obtener un usuario por ID

```bash
curl -X GET http://localhost:8000/api/users/1 \
  -H "Accept: application/json"
```

### Crear un usuario

```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name": "Diana", "email": "diana@example.com", "age": 28}'
```

### Actualizar un usuario

```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name": "Alice Updated", "age": 31}'
```

### Eliminar un usuario

```bash
curl -X DELETE http://localhost:8000/api/users/1 \
  -H "Accept: application/json"
```

### Intentar acceder a un usuario inexistente

```bash
curl -X GET http://localhost:8000/api/users/999 \
  -H "Accept: application/json"
# Respuesta 404: { "error": "Usuario no encontrado" }
```

---

## Licencia

Este proyecto está bajo la licencia [MIT](https://opensource.org/licenses/MIT).
