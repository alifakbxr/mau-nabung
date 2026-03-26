# Maunabung - Personal Finance Management Application

> A modern, secure, and user-friendly personal finance web application built with vanilla PHP, MySQL, and Bootstrap 5.

![PHP](https://img.shields.io/badge/PHP-7.4+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![Release](https://img.shields.io/badge/release-1.0.0-blue.svg)

[![Features](https://img.shields.io/badge/features-complete-brightgreen.svg)](#-features)
[![Security](https://img.shields.io/badge/security-A+-red.svg)](#-security--integrity)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)

---

## 📖 Table of Contents

- [About](#-about)
- [Features](#-features)
- [Quick Start](#-quick-start)
- [Documentation](#-documentation)
- [Architecture](#-architecture)
- [Development](#-development)
- [Security](#-security--integrity)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🎯 About

**Maunabung** (from Indonesian "mau nabung" = "want to save") is a comprehensive personal finance management application designed to help individuals track income, expenses, savings goals, and budgets with accounting-grade accuracy.

Built with **vanilla PHP** (no framework overhead) and **Bootstrap 5**, Maunabung combines simplicity with powerful features like:
- Double-entry lite accounting system
- Complete audit trail with encryption
- Multi-account support (cash, bank, e-wallet, investments, credit cards)
- ACID-compliant transactions
- BCMath precision for financial calculations

---

## 🌟 Features

### 💰 Core Functionality

| Feature | Description |
|---------|-------------|
| **User Authentication** | Secure registration, login, and profile management with currency preferences |
| **Interactive Dashboard** | Real-time financial summaries, expense charts, and recent activity |
| **Transaction Management** | Record income/expenses with date/category filtering and search |
| **Multi-Account Support** | Track cash, bank, e-wallets, investments, credit cards, and loans |
| **Savings Goals** | Set targets, track progress, and use simulation calculator |
| **Budget Tracking** | Monitor spending limits by category with period support |
| **Salary Allocator** | Smart income distribution planning with percentages |
| **Reports & Export** | Generate financial reports and export to CSV |
| **Categories** | Custom income/expense categories with color labels |
| **Audit Trail** | Complete history of all changes with encryption |

### 🔒 Security & Integrity

- **Double-Entry Lite System** - ACID-compliant transaction logic prevents balance errors
- **Complete Audit Trail** - Every change logged with encrypted before/after values
- **Soft Deletes** - Deleted transactions marked void, not permanently removed
- **Lock Date Protection** - Prevent modifications to closed accounting periods
- **BCMath Precision** - Accurate financial calculations without floating-point errors
- **CSRF Protection** - Token-based form protection on all POST requests
- **SQL Injection Prevention** - Prepared statements (PDO) throughout
- **XSS Protection** - Output escaping via `esc()` helper on all user inputs
- **Password Hashing** - Bcrypt with cost factor 10 for credential security

---

## 🚀 Quick Start

### Prerequisites

| Requirement | Version | Notes |
|-------------|---------|-------|
| PHP | 7.4+ | Recommended: 8.1+ |
| MySQL | 5.7+ | InnoDB engine required |
| Web Server | Apache 2.4+ / Nginx 1.18+ | Or PHP built-in server |
| PHP Extensions | `pdo`, `bcmath` | Required for database and calculations |

### Installation (5 minutes)

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/maunabung.git
   cd maunabung
   ```

2. **Create the database**
   ```sql
   CREATE DATABASE maunabung CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import the schema**
   ```bash
   mysql -u root -p maunabung < db/schema.sql
   ```
   
   > **Note**: Run migrations if available:
   > ```bash
   > mysql -u root -p maunabung < db/migrations/001_accounting_hardening.sql
   > ```

4. **Configure database connection**
   
   Edit `config/database.php`:
   ```php
   return [
       'host' => 'localhost',
       'dbname' => 'maunabung',
       'username' => 'root',
       'password' => 'your_password',
       'charset' => 'utf8mb4'
   ];
   ```

5. **Run the application**
   ```bash
   php -S localhost:8000 -t public
   ```

6. **Access the application**
   
   Open your browser: `http://localhost:8000`

### 🐳 Docker Quick Start

```bash
docker-compose up -d
```

Access at: `http://localhost:8080`

---

## 📚 Documentation

| Document | Description |
|----------|-------------|
| **[README.md](README.md)** | This file - quick start and overview |
| **[QWEN.md](QWEN.md)** | Technical documentation and architecture |
| **[CONTRIBUTING.md](CONTRIBUTING.md)** | Contribution guidelines and coding standards |
| **[CHANGELOG.md](CHANGELOG.md)** | Version history and changes |
| **[SECURITY.md](SECURITY.md)** | Security policy and best practices |
| **[docs/DEPLOYMENT.md](docs/DEPLOYMENT.md)** | Production deployment guide |
| **[docs/DATABASE.md](docs/DATABASE.md)** | Complete database schema reference |
| **[docs/WIKI.md](docs/WIKI.md)** | Comprehensive wiki and user guide |

### 📖 Quick Links

**For Users:**
- [Installation Guide](#-installation)
- [Features Overview](#-features)
- [Troubleshooting](#-troubleshooting)

**For Developers:**
- [Architecture Overview](#-architecture)
- [Development Guide](#-development)
- [Database Schema](docs/DATABASE.md)

**For Contributors:**
- [Contributing Guidelines](CONTRIBUTING.md)
- [Code Standards](CONTRIBUTING.md#coding-standards)
- [Pull Request Template](.github/PULL_REQUEST_TEMPLATE.md)

---

## 🏗️ Architecture

### MVC Pattern

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Request   │ ──► │ Controller  │ ──► │   Service   │
└─────────────┘     └─────────────┘     └─────────────┘
                           │                   │
                           ▼                   ▼
                     ┌─────────────┐     ┌─────────────┐
                     │    View     │     │    Model    │
                     └─────────────┘     └─────────────┘
                                                │
                                                ▼
                                         ┌─────────────┐
                                         │  Database   │
                                         └─────────────┘
```

### Key Components

| Component | File | Purpose |
|-----------|------|---------|
| **Router** | `app/Core/Router.php` | Pattern-matching URL routing |
| **Database** | `app/Core/Database.php` | Singleton PDO connection manager |
| **Model** | `app/Core/Model.php` | Base model with CRUD operations |
| **View** | `app/Core/View.php` | Template renderer |
| **Security** | `app/Core/Security.php` | CSRF, XSS, encryption utilities |
| **AccountingService** | `app/Services/AccountingService.php` | Core financial transaction logic |

### Transaction Flow

```
User Action → Controller → AccountingService → Model → Database
                ↓                                      │
                │                                      ▼
                │                                Audit Log
                ▼
              View (Bootstrap 5)
```

---

## 🛠️ Development

### Project Structure

```
maunabung/
├── app/
│   ├── Controllers/        # HTTP request handlers
│   ├── Core/               # Framework foundation
│   ├── Models/             # Database interactions
│   ├── Services/           # Business logic layer
│   └── Views/              # HTML templates
├── config/                 # Configuration files
├── db/                     # Database schema & migrations
├── public/                 # Web root directory
├── docs/                   # Documentation
├── utils/                  # Utility scripts
└── .github/                # GitHub templates
```

See [QWEN.md](QWEN.md#project-structure) for complete structure.

### Adding Features

#### New Route
```php
// public/index.php
$router->add('GET', '/new-page', 'PageController', 'newMethod');
```

#### New Controller
```php
// app/Controllers/NewController.php
namespace App\Controllers;

class NewController {
    public function index() {
        // Handle request
    }
}
```

#### New Model
```php
// app/Models/NewModel.php
namespace App\Models;

use App\Core\Model;

class NewModel extends Model {
    protected $table = 'new_table';
}
```

### Running Migrations

```bash
mysql -u root -p maunabung < db/migrations/00X_migration_name.sql
```

### Code Quality

We follow **PSR-12** coding standards. See [CONTRIBUTING.md](CONTRIBUTING.md#coding-standards) for details.

---

## 🔒 Security & Integrity

### Security Layers

| Layer | Protection | Implementation |
|-------|------------|----------------|
| **Authentication** | Password security | Bcrypt hashing (cost 10) |
| **Session** | Hijacking prevention | HTTPOnly, Secure cookies |
| **Input** | XSS attacks | Output escaping via `esc()` |
| **Database** | SQL injection | Prepared statements (PDO) |
| **Forms** | CSRF attacks | Token validation |
| **Data** | Privacy | Audit logging with encryption |
| **Calculations** | Precision errors | BCMath library |

### Audit Trail

All sensitive operations are logged:

```sql
SELECT * FROM audit_logs 
WHERE user_id = :user_id 
ORDER BY created_at DESC 
LIMIT 100;
```

See [SECURITY.md](SECURITY.md) for complete security documentation.

---

## 💾 Database

### Core Tables

| Table | Records | Description |
|-------|---------|-------------|
| `users` | User accounts | Authentication and preferences |
| `accounts` | Financial accounts | Balance tracking by type |
| `categories` | Transaction categories | Income/expense classification |
| `transactions` | All transactions | ACID-compliant records |
| `savings_goals` | Goal tracking | Target vs current progress |
| `budgets` | Budget limits | Category spending caps |
| `audit_logs` | Change history | Complete audit trail |

See [docs/DATABASE.md](docs/DATABASE.md) for complete schema reference.

### Transaction Types

| Type | Balance Impact | Use Case |
|------|----------------|----------|
| `income` | +account | Salary, freelance, gifts |
| `expense` | -account | Shopping, bills, food |
| `transfer` | -source, +destination | Between accounts |
| `adjustment` | ±account | Corrections, fees |

---

## 🐛 Troubleshooting

### Common Issues

| Problem | Solution |
|---------|----------|
| **Database connection failed** | Verify MySQL is running, check credentials in `config/database.php` |
| **404 on all routes** | Enable `mod_rewrite` on Apache, ensure `.htaccess` files exist |
| **Balance discrepancies** | Run `AccountingService::reconcileBalance()` for the account |
| **Session not working** | Check PHP session configuration and directory permissions |
| **Blank page** | Check error logs: `tail -f /var/log/php_errors.log` |

### Debug Mode

Enable error reporting for development:

```php
// Add to public/index.php (development only!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Getting Help

1. Check [docs/WIKI.md](docs/WIKI.md)
2. Review [FAQ](docs/WIKI.md#faq)
3. Search existing [issues](https://github.com/your-username/maunabung/issues)
4. Create a new [issue](CONTRIBUTING.md#bug-reports)

---

## 🤝 Contributing

We welcome contributions! Here's how to help:

### Ways to Contribute

- 🐛 Report bugs
- ✨ Suggest features
- 📝 Improve documentation
- 💻 Submit code fixes
- 🧪 Test and review PRs

### Quick Start

```bash
# 1. Fork the repository
# 2. Clone your fork
git clone https://github.com/your-username/maunabung.git

# 3. Create a branch
git checkout -b feature/your-feature

# 4. Make changes and commit
git commit -m "feat: add amazing feature"

# 5. Push and create PR
git push origin feature/your-feature
```

### Guidelines

- Read [CONTRIBUTING.md](CONTRIBUTING.md) first
- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Write clear commit messages (conventional commits)
- Test your changes thoroughly
- Update documentation if needed

### Need Help?

- [Issue Templates](.github/ISSUE_TEMPLATE.md)
- [PR Template](.github/PULL_REQUEST_TEMPLATE.md)
- [Code of Conduct](CODE_OF_CONDUCT.md)

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

```
MIT License

Copyright (c) 2024 Maunabung

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software...
```

---

## 📧 Support

### Get Help

- **Documentation**: [docs/WIKI.md](docs/WIKI.md)
- **Issues**: [GitHub Issues](https://github.com/your-username/maunabung/issues)
- **Security**: [SECURITY.md](SECURITY.md)

### Contact

For questions or support:
1. Check existing [issues](https://github.com/your-username/maunabung/issues)
2. Create a new [issue](CONTRIBUTING.md#bug-reports)
3. Email: support@maunabung.local (if available)

---

## 🙏 Acknowledgments

- [Bootstrap](https://getbootstrap.com/) - UI framework
- [PHP](https://www.php.net/) - Backend language
- [MySQL](https://www.mysql.com/) - Database
- All contributors and supporters

---

<p align="center">
  <strong>Built with ❤️ for better financial management</strong><br>
  <em>Maunabung - Save and grow your money wisely</em>
</p>

<p align="center">
  <a href="#maunabung---personal-finance-management-application">↑ Back to top ↑</a>
</p>
