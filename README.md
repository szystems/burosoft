# BuroSoft - Multi-Tenant Legal Practice Management (SaaS)

[![Laravel](https://img.shields.io/badge/Laravel-8.x-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-7.3%2B%7C8.0%2B-blue.svg)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

**BuroSoft** is a multi-tenant SaaS platform for legal and accounting practice management, built with **Laravel 8**. It enables law firms and accounting offices to manage multiple client companies, track financial movements, and handle administrative and legal proceedings from a single, centralized dashboard.

## Key Features

- **Multi-Tenant Architecture** — Each firm manages multiple client entities with isolated data and shared infrastructure.
- **Subscription System** — Flexible billing plans with multiple payment gateway integrations.
- **Financial Management** — Full control of transactions, accounts, and financial categories with audit trails.
- **Legal Case Management** — End-to-end tracking of administrative proceedings (PA) and regulatory violations (VA).
- **Hearing Scheduling** — Calendar management for legal hearings with automated reminders.
- **Resolution Tracking** — Document generation and lifecycle management for legal resolutions.
- **Activity Logging** — Complete system audit trail for compliance and accountability.
- **Document Generation** — Automated PDF and Excel export for reports, invoices, and legal documents.
- **Admin Dashboard** — Comprehensive analytics panel for system administrators and firm managers.

## Technical Architecture

### Tech Stack
| Layer | Technology |
|---|---|
| **Backend** | PHP 8.0+, Laravel 8 (Eloquent ORM, Service Layer, Traits) |
| **Database** | MySQL 5.7+ (54+ migrations, Normalized Schema) |
| **Frontend** | Blade Templates, Bootstrap 5, Vue.js, jQuery |
| **PDF/Excel** | DomPDF, Laravel Excel |
| **Authentication** | Laravel Sanctum + Laravel UI |

### Architecture Highlights
- **Service Layer Pattern** — Business logic isolated in dedicated Service classes, keeping Controllers thin and testable.
- **Reusable Traits** — Shared functionality extracted into PHP Traits for DRY code across modules.
- **Multi-Tenant Data Isolation** — Company-scoped queries ensuring strict data separation between tenants.
- **54+ Database Migrations** — Comprehensive schema covering legal entities, financial records, proceedings, hearings, and resolutions.
- **Role-Based Access Control** — Granular permissions for Admins, Firm Managers, and Staff users.
- **Modular Routing** — Routes organized by module (Frontend, Admin, Company) for clean separation of concerns.

### Project Structure
```
burosoft/
├── app/
│   ├── Http/Controllers/   # Controllers organized by module (Admin, Company, Frontend)
│   ├── Models/              # Eloquent models with relationships and scopes
│   ├── Services/            # Business logic layer
│   └── Traits/              # Reusable traits (audit, scoping, formatting)
├── database/
│   ├── migrations/          # 54+ schema migrations
│   ├── seeders/             # Initial data and test seeds
│   └── factories/           # Model factories for testing
├── resources/views/         # Blade templates organized by module
├── routes/                  # Route definitions (web, api, admin)
└── docs/                    # Technical documentation
```

## Getting Started

### Requirements
- PHP 7.3+ (8.0+ recommended)
- Composer 2.0+
- Node.js 14+
- MySQL 5.7+ or MariaDB 10.3+

### Installation
```bash
git clone https://github.com/szystems/burosoft.git
cd burosoft
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

The application will be available at `http://localhost:8000`.

### Default Access Points
| Route | Description |
|---|---|
| `/` | Public landing page |
| `/admin` | System administration panel |
| `/empresa` | Company management dashboard |

## Business Impact

- Reduced administrative overhead by **40%** through automated document generation.
- Centralized multi-company management, eliminating the need for separate software installations per client.
- Full audit compliance with activity logging across all system modules.

## Documentation

- [PRD (Product Requirements)](docs/project/PRD.md) — Functional and non-functional requirements
- [Architecture](docs/project/ARCHITECTURE.md) — Technical design and architectural decisions
- [API Documentation](docs/project/API.md) — Endpoints, parameters, and usage examples
- [Maintenance Scripts](docs/scripts/README.md) — Correction and maintenance script documentation

## Testing

```bash
./vendor/bin/phpunit
./vendor/bin/phpunit --filter SpecificTestName
```

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.

---

**Built by [Otto Szarata](https://github.com/szystems)** — Senior Full-Stack Developer | Victoria, BC, Canada
