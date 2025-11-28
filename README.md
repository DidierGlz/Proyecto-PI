# Producto Integrador – Mi aplicación construida con lenguajes de programación Backend
## Lenguajes de Programación Back End  
**Alumno:** Néstor Didier Lino González  
**Materia:** Lenguajes de Programación Backend  
**Producto Integrador**  
**Fecha:** 27/11/2025  

---

## Cómo ejecutar el proyecto

1. Descargar o clonar el repositorio.

2. Crear base de datos `ldsw_mvc` en MySQL, seleccionarla e irse a importar.

3. Importar el archivo `database.sql` que está en la raíz de la carpeta.

4. En la carpeta raíz que descargaste, ejecutar este comando en una terminal para instalar las dependencias necesarias:

composer install

5. Configurar .env con:

    app.baseURL = 'http://localhost/proyecto_ci/public/'

    encryption.key = 'base64:puedes obtener una en internet o utilizar php para generarla (lo dejo abajo)'



    O simplemente borrar el ".ejemplo" de ".env.ejemplo".


6. Iniciar XAMPP (Apache + MySQL).

7. Entrar a: http://localhost/proyecto_ci/public/login

8. Usuarios de prueba por si no quieres crear uno: 

 User: prueba001

 password: 12345678

 User: prueba002

 password: 0000

9. Código para generar el base64 con PHP: php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"

## 🧩 Descripción general
Este proyecto es el **producto integrador final del curso**, en el cual se desarrolla una aplicación web completa de tipo **cliente/servidor** utilizando:

- **PHP** (CodeIgniter 4) desde el lado del servidor  
- **HTML, CSS y JavaScript** desde el lado del cliente  
- **MySQL** para persistencia de datos  
- **MVC** como arquitectura principal  
- **Bootstrap 5** para diseño web responsivo  
- **Sesiones y cookies** para autenticación  

La aplicación implementa:

- **Autenticación con roles (admin / usuario común)**  
- **CRUD de usuarios (solo administrador)**  
- **Galería de imágenes por usuario**  
- **Subida, filtrado, categorización y eliminación de imágenes**  
- **Administrador puede gestionar imágenes de cualquier usuario**  
- **Panel de generación de documentos (Word, Excel, PDF)**  
- **Diseño responsivo y navegación clara entre módulos**

Se trata de un sistema completo que simula una aplicación real de gestión y administración de archivos.

---

## 🗂️ Estructura del proyecto

proyecto_ci/
│
├─ app/
│ ├─ Controllers/
│ │ ├─ Auth.php
│ │ ├─ Users.php
│ │ ├─ Images.php
│ │ └─ Documents.php
│ │
│ ├─ Filters/
│ │ ├─ AuthFilter.php
│ │ └─ RememberMeFilter.php
│ │
│ ├─ Models/
│ │ ├─ UserModel.php
│ │ └─ ImageModel.php
│ │
│ └─ Views/
│ ├─ layout/
│ │ ├─ header.php
│ │ └─ footer.php
│ │
│ ├─ auth/
│ │ └─ login.php
│ │
│ ├─ users/
│ │ ├─ index.php
│ │ └─ form.php
│ │
│ ├─ images/
│ │ └─ index.php
│ │
│ └─ documents/
│ └─ index.php
│
├─ public/
│ ├─ uploads/
│ │ └─ images/
│ └─ js/
│ ├─ login.js
│ ├─ confirmDelete.js
│ ├─ validateUserForm.js
│ └─ gallery.js
│
└─ .env

---

## 🔐 Autenticación con sesiones, cookies y roles

### Características:
- Login con validación en servidor y cliente (JS).  
- Sesión `session('user')` para mantener autenticación.  
- Cookie **“remember me”** firmada con HMAC.  
- Filtro `AuthFilter` protege todas las rutas privadas.  
- Filtro `RememberMeFilter` autologuea si existe cookie válida.  
- Botón “Salir” elimina cookie + sesión.  
- **Roles:**  
  - `admin` → Acceso completo, gestión de usuarios e imágenes de todos.  
  - `user`  → Solo puede ver y gestionar su propia galería.

---

## 👥 Módulo de usuarios (solo administradores)

Funciones:
- Listado completo de usuarios  
- Crear nuevos usuarios  
- Editar usuarios existentes  
- Eliminar usuarios  
- Admin asignado desde BD mediante atributo `role = 'admin'`

La contraseña se almacena usando:

```php
password_hash($password, PASSWORD_DEFAULT)

y se valida con:

password_verify($input, $user['password_hash'])

Módulo de imágenes (galería por usuario)
Funciones:

Subir imágenes (JPG, PNG, GIF, WebP)

Añadir título y categoría opcional

Ver imágenes en forma de galería (cards)

Filtrar por categoría

Eliminar imágenes

Admin puede elegir ver la galería de cualquier usuario mediante dropdown

Las imágenes se guardan físicamente en:
public/uploads/images/

Cada imagen pertenece a un usuario:

user_id INT UNSIGNED NOT NULL

y solo el propietario o el admin pueden borrarla.

- Base de datos

Tabla user
CREATE TABLE user (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(256) NOT NULL,
  login VARCHAR(128) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user'
);

Tabla images
CREATE TABLE images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  filename VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  category VARCHAR(100),
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_images_user FOREIGN KEY (user_id)
    REFERENCES user(id) ON DELETE CASCADE
);

- Módulo de documentos (Word, Excel, PDF)

Incluye un panel ubicado en /documents.

Genera reportes con todos los usuarios registrados:

Word (.docx) → usando PhpOffice\PhpWord

Excel (.xlsx) → usando PhpOffice\PhpSpreadsheet

PDF (.pdf) → usando TCPDF

Cada documento incluye:

Portada con datos de la actividad

Fecha actual

Tabla de usuarios

- Interfaz y experiencia de usuario (UX/UI)

Diseño responsivo con Bootstrap 5

Barra de navegación persistente:

Usuarios

Imágenes

Documentos

Salir

Cards para las imágenes

Iconos claros y botones visibles

Validaciones con JavaScript

Retroalimentación visual (alertas, mensajes, filtros)

Rutas principales

Públicas:
| Ruta      | Descripción          |
| --------- | -------------------- |
| `/login`  | Formulario de acceso |
| `/logout` | Cerrar sesión        |

Protegidas por auth:
| Ruta         | Módulo                                  |
| ------------ | --------------------------------------- |
| `/users`     | Administración de usuarios (solo admin) |
| `/images`    | Galería de imágenes                     |
| `/documents` | Panel de documentos                     |

- Lado del cliente

HTML5 para la estructura

CSS3 + Bootstrap para diseño responsivo

JavaScript para validaciones y acciones:

login.js → validación de login + mostrar/ocultar contraseña

confirmDelete.js → confirmar eliminaciones

validateUserForm.js → validación CRUD de usuarios

gallery.js → validación de subida de imágenes

- Referencias APA

Ortiz, J. P. (2020). Tutorial de CodeIgniter [Tutorial]. UDGVirtual.

Ortiz, J. P. (2020). Tipos de Respuestas – Documentos [Tutorial]. UDGVirtual.

CodeIgniter Foundation. (s. f.). CodeIgniter 4 User Guide. https://codeigniter.com/user_guide/

Composer. (s. f.). Dependency Manager for PHP. https://getcomposer.org/
