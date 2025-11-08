


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
