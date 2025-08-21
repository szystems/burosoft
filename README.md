# BuroSoft - Sistema de Gestión Legal y Contable

[![Laravel](https://img.shields.io/badge/Laravel-8.x-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-7.3%2B-blue.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

BuroSoft es un sistema integral de gestión legal y contable desarrollado en Laravel 8, diseñado para abogados y contadores que necesitan administrar múltiples empresas, llevar control de movimientos financieros y gestionar procesos administrativos y violaciones administrativas.

## 🚀 Características Principales

- **Gestión Multi-empresa**: Administración de múltiples empresas desde una sola plataforma
- **Sistema de Suscripciones**: Planes flexibles con múltiples plataformas de pago
- **Gestión Contable**: Control completo de movimientos, cuentas y rubros financieros
- **Procesos Administrativos (PA)**: Gestión integral de procedimientos administrativos
- **Violaciones Administrativas (VA)**: Control de expedientes y procesos de violaciones
- **Sistema de Bitácoras**: Registro completo de actividades del sistema
- **Panel de Administración**: Dashboard completo para administradores y empresas
- **Generación de Documentos**: Exportación a PDF y Excel

## 📋 Requisitos del Sistema

- **PHP**: 7.3 o superior (8.0+ recomendado)
- **Composer**: 2.0 o superior
- **Node.js**: 14.x o superior
- **MySQL**: 5.7 o superior / MariaDB 10.3+
- **Extensiones PHP requeridas**:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
  - GD (para generación de PDFs)

## 🛠️ Instalación y Configuración

### 1. Clonar el Repositorio
```bash
git clone https://github.com/szystems/burosoft.git
cd burosoft
```

### 2. Instalar Dependencias
```bash
# Dependencias de PHP
composer install

# Dependencias de Node.js
npm install
```

### 3. Configuración del Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar Base de Datos
Editar el archivo `.env` con los datos de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=burosoft
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5. Ejecutar Migraciones y Seeders
```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders (opcional)
php artisan db:seed
```

### 6. Compilar Assets
```bash
# Para desarrollo
npm run dev

# Para producción
npm run production
```

### 7. Configurar Permisos
```bash
# Linux/macOS
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Windows (ejecutar como administrador)
icacls storage /grant Everyone:F /t
icacls bootstrap\cache /grant Everyone:F /t
```

## 🏗️ Estructura del Proyecto

### Módulos Principales

1. **Frontend**: Landing page y sistema de suscripciones
2. **Admin**: Panel de administración del sistema
3. **Empresa**: Dashboard y gestión por empresa

### Entidades Principales

- **PAT**: Proceso Administrativo Tributario
- **VA/PA**: Violaciones/Procesos Administrativos  
- **Movimientos**: Transacciones financieras
- **Audiencias**: Gestión de audiencias legales
- **Resoluciones**: Documentos de resolución
- **Empresas**: Entidades cliente del sistema

### Estructura de Carpetas

```
burosoft/
├── app/                    # Código fuente de la aplicación
│   ├── Http/Controllers/   # Controladores organizados por módulo
│   ├── Models/            # Modelos Eloquent
│   ├── Services/          # Lógica de negocio
│   └── Traits/            # Traits reutilizables
├── database/
│   ├── migrations/        # 54+ migraciones del sistema
│   ├── seeders/          # Datos iniciales
│   └── factories/        # Factories para testing
├── resources/
│   ├── views/            # Vistas Blade organizadas por módulo
│   ├── js/               # JavaScript y Vue.js
│   └── css/              # Estilos CSS/SCSS
├── routes/               # Definición de rutas
├── scripts/              # Scripts de mantenimiento y corrección
├── docs/                 # Documentación del proyecto
│   ├── project/          # Documentación técnica principal
│   ├── scripts/          # Documentación de scripts
│   └── temp/             # Archivos temporales
└── temp/                 # Archivos temporales de desarrollo
```

## 🔗 Documentación Adicional

- [**PRD (Product Requirements Document)**](docs/project/PRD.md) - Requerimientos funcionales y no funcionales
- [**Arquitectura del Sistema**](docs/project/ARCHITECTURE.md) - Diseño técnico y decisiones arquitectónicas  
- [**Documentación de API**](docs/project/API.md) - Endpoints, parámetros y ejemplos de uso
- [**Scripts de Mantenimiento**](docs/scripts/README.md) - Documentación de scripts de corrección y mantenimiento

## 🚀 Uso Rápido

### Iniciar Servidor de Desarrollo
```bash
php artisan serve
```
El sistema estará disponible en: `http://localhost:8000`

### Acceso por Defecto
- **Admin**: `/admin` 
- **Empresa**: `/empresa`
- **Frontend**: `/`

## 🧪 Testing

```bash
# Ejecutar todas las pruebas
./vendor/bin/phpunit

# Ejecutar pruebas específicas
./vendor/bin/phpunit --filter NombreDeLaPrueba
```

## 🤝 Contribución

1. Fork el proyecto
2. Crear rama de feature (`git checkout -b feature/nueva-caracteristica`)
3. Commit los cambios (`git commit -am 'Agregar nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Crear Pull Request

## 📜 Licencia

Este proyecto está bajo la Licencia MIT. Ver [LICENSE](LICENSE) para más detalles.

## 🆘 Soporte

Para soporte técnico o reportar bugs, crear un issue en el repositorio o contactar al equipo de desarrollo.

---

**Desarrollado por SZSystems** • [GitHub](https://github.com/szystems) • Versión 2.0

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
