


# Proyecto Symfony (Docker)

Este proyecto es una aplicación desarrollada con **Symfony**, que se ejecuta dentro de un entorno **Docker**.  
Incluye base de datos y datos de ejemplo (fixtures) para probar el sistema fácilmente.

---

## 🚀 Requisitos

Antes de comenzar, asegúrate de tener instalados:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

---

## 📦 Instalación

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/PolMelo/ViajesPol.git
cd ViajesPol
```
---

### 2️⃣ Levantar el entorno Docker

Ejecuta el siguiente comando para construir y levantar los contenedores:

```bash

docker-compose up -d --build

```

### 3️⃣ Instalar dependencias

## 📦 Dependencias principales

El proyecto utiliza las siguientes librerías y bundles de Symfony y Doctrine:

| Paquete | Descripción |
|----------|-------------|
| **symfony/framework-bundle** | Núcleo del framework Symfony: controla el ciclo de vida de la aplicación y el contenedor de servicios. |
| **symfony/runtime** | Punto de entrada moderno para iniciar la aplicación Symfony. |
| **symfony/http-foundation** | Maneja las peticiones y respuestas HTTP. |
| **symfony/routing** | Define las rutas (URLs) de la aplicación. |
| **symfony/dependency-injection** | Gestiona los servicios y la inyección de dependencias. |
| **symfony/config** | Carga y procesa configuraciones desde archivos YAML, PHP o XML. |
| **symfony/yaml** | Permite leer y escribir archivos YAML. |
| **symfony/twig-bundle** | Motor de plantillas Twig, utilizado para las vistas. |
| **symfony/security-bundle** | Gestiona autenticación, roles y seguridad. |
| **symfony/orm-pack** | Paquete que instala e integra Doctrine ORM con Symfony. |
| **doctrine/orm** | ORM que mapea las entidades PHP a tablas en la base de datos. |
| **doctrine/doctrine-bundle** | Integración entre Symfony y Doctrine. |
| **doctrine/doctrine-migrations-bundle** | Permite crear y ejecutar migraciones en la base de datos. |

---

### 🧪 Dependencias de desarrollo

Estas se usan solo en entorno de desarrollo:

| Paquete | Descripción |
|----------|-------------|
| **symfony/maker-bundle** | Genera código automáticamente con comandos (`make:entity`, `make:controller`, etc.). |
| **doctrine/doctrine-fixtures-bundle** | Permite cargar datos de prueba (fixtures) en la base de datos. |

---

✅ Con estas dependencias, el proyecto incluye:
- Sistema de login y roles.
- Motor de plantillas Twig.
- Gestión ORM con Doctrine.
- Migraciones y fixtures.
- Herramientas para desarrollo rápido.





### 4️⃣ Configurar variables de entorno

```bash
cp .env .env.local
```
Verifica que la variable DATABASE_URL esté correctamente configurada:

(Esta es mi configuració)
```bash
DATABASE_URL="mysql://root:pol2812@db:3306/viajespol"
```

Si se quiere usar una DB propia:

```bash
DATABASE_URL="mysql://miusuario:mipassword@localhost:3306/mibase"

```

💡 Nota: La conexión DATABASE_URL ya está configurada para funcionar con el entorno Docker incluido.
Solo cámbiala si vas a usar una base de datos diferente o no estás utilizando Docker.


### 5️⃣ Crear y cargar la base de datos

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load


```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

### 6️⃣ Acceder a la aplicación

#### 🔑 Credenciales de acceso

El proyecto incluye dos usuarios de ejemplo cargados automáticamente mediante *fixtures*.

| Rol | Email | Contraseña | Permisos |
|-----|--------|-------------|-----------|
| 👁️ Visualizador | ver@viajes.com | solomiro | Solo lectura (ver datos, sin modificar la entidad/tabla) |
| 🛠️ Administrador | admin@viajes.com | admin123 | Acceso completo (ver, rear, actualizar y eliminar datos) |

---

#### 🧭 Acceso a la aplicación

Una vez que el proyecto esté levantado y las *fixtures* se hayan cargado, podreis acceder al sistema en:

👉 [http://localhost:8080](http://localhost:8080)

Luego, inicia sesión con uno de los usuarios de prueba anteriores según el tipo de acceso que quieras probar.


 ### 7️⃣ 🧰 Tecnologías principales

Symfony 7.3

PHP 8+

MySQL 8.0

Docker & Docker Compose

Doctrine ORM

Fixtures Bundle

Twig

 ### 8️⃣ 👤 Autor

Pol Melo 
[GitHub](https://github.com/PolMelo/)  
[LinkedIn](https://www.linkedin.com/in/polmelo/)
