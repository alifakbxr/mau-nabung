# Maunabung - Personal Finance Management Application

> A modern, secure, and user-friendly personal finance web application built with vanilla PHP, MySQL, and Bootstrap 5.

![PHP](https://img.shields.io/badge/PHP-7.4+-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 🌟 Features

### Core Functionality
- **User Authentication** - Secure registration, login, and profile management with currency preferences
- **Interactive Dashboard** - Real-time financial summaries, expense charts, and recent activity overview
- **Transaction Management** - Record income and expenses with date/category filtering
- **Multi-Account Support** - Track cash, bank accounts, e-wallets, investments, and credit cards
- **Savings Goals** - Set and track progress toward financial goals with simulation tools
- **Budget Tracking** - Monitor spending limits by category
- **Salary Allocator** - Smart income distribution planning
- **Reports & Export** - Generate financial reports and export to CSV

### Security & Integrity
- **Double-Entry Lite System** - ACID-compliant transaction logic prevents balance errors
- **Complete Audit Trail** - Every change is logged with encrypted before/after values
- **Soft Deletes** - Deleted transactions are marked void, not permanently removed
- **Lock Date Protection** - Prevent modifications to closed accounting periods
- **BCMath Precision** - Accurate financial calculations without floating-point errors
- **CSRF Protection** - Token-based form protection
- **SQL Injection Prevention** - Prepared statements throughout
- **XSS Protection** - Output escaping on all user inputs
- **Password Hashing** - Bcrypt encryption for credentials

## 🚀 Quick Start

### Prerequisites

- PHP >= 7.4 (Recommended: 8.1+)
- MySQL / MariaDB (InnoDB engine required)
- Web server (Apache/Nginx) or PHP built-in server
- Required PHP extensions: `pdo`, `bcmath`

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url> maunabung
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
   
   > **Note**: If migrations exist, run them too:
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
   
   Open your browser and navigate to: `http://localhost:8000`

## 📁 Project Structure

```
maunabung/
├── app/
│   ├── Controllers/        # Request handlers
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── TransactionController.php
│   │   ├── CategoryController.php
│   │   ├── AccountController.php
│   │   ├── SavingsGoalController.php
│   │   ├── ReportController.php
│   │   ├── SalaryController.php
│   │   ├── ProfileController.php
│   │   └── PageController.php
│   ├── Core/               # Framework components
│   │   ├── Database.php    # Singleton DB connection
│   │   ├── Router.php      # Routing system
│   │   ├── Model.php       # Base model class
│   │   ├── View.php        # Template renderer
│   │   └── Security.php    # Security utilities
│   ├── Models/             # Database layer
│   │   ├── User.php
│   │   ├── Transaction.php
│   │   ├── Category.php
│   │   ├── Account.php
│   │   ├── SavingsGoal.php
│   │   ├── Settings.php
│   │   └── AuditLog.php
│   ├── Services/           # Business logic
│   │   └── AccountingService.php  # Financial operations
│   └── Views/              # HTML templates
│       ├── auth/
│       ├── dashboard/
│       ├── transactions/
│       ├── categories/
│       ├── accounts/
│       ├── goals/
│       ├── reports/
│       ├── salary/
│       ├── profile/
│       ├── pages/
│       ├── layouts/
│       └── 404.php
├── config/
│   └── database.php        # Database configuration
├── db/
│   ├── schema.sql          # Database schema
│   └── migrations/         # Database migrations
├── public/                 # Web root
│   ├── index.php           # Entry point
│   ├── .htaccess           # URL rewriting
│   └── assets/             # CSS, JS, images
├── utils/
│   └── backup.php          # Database backup utility
├── .htaccess               # Root URL rewriting
├── .gitignore              # Git ignore rules
└── README.md
```

## 🏗️ Architecture

### MVC Pattern
- **Models** - Database interactions extending base `Model` class
- **Views** - PHP templates with Bootstrap 5 styling
- **Controllers** - HTTP request handlers invoking services

### Key Components

| Component | Purpose |
|-----------|---------|
| `Router` | Pattern-matching URL routing |
| `Database` | Singleton PDO connection manager |
| `AccountingService` | Core financial transaction logic |
| `Security` | CSRF, XSS, encryption utilities |

### Transaction Flow

```
Controller → Service → Model → Database
    ↓                      ↓
  View ←────────────── Audit Log
```

## 💾 Database Schema

### Core Tables

| Table | Description |
|-------|-------------|
| `users` | User accounts with credentials |
| `accounts` | Financial accounts (cash, bank, e-wallet, etc.) |
| `categories` | Income/expense categories |
| `transactions` | All financial transactions |
| `savings_goals` | Goal tracking with progress |
| `budgets` | Category spending limits |
| `recurring_transactions` | Scheduled recurring entries |
| `settings` | User preferences and configurations |
| `audit_logs` | Complete change history |

### Transaction Types

- **income** - Money received (increases balance)
- **expense** - Money spent (decreases balance)
- **transfer** - Between accounts (source ↓, destination ↑)
- **adjustment** - Balance corrections (± amount)

## 🛠️ Development

### Adding a New Route

Edit `public/index.php`:
```php
$router->add('GET', '/new-page', 'PageController', 'newMethod');
```

### Adding a New Controller

```php
// app/Controllers/NewController.php
namespace App\Controllers;

class NewController {
    public function index() {
        // Handle request
    }
}
```

### Adding a New Model

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

## 🔒 Security Best Practices

1. **Never commit sensitive data** - Use `.env` files for credentials (not included in repo)
2. **Keep `bcmath` enabled** - Required for accurate financial calculations
3. **Review audit logs regularly** - Check `audit_logs` table for anomalies
4. **Backup database frequently** - Use `utils/backup.php` or MySQL dump
5. **Use HTTPS in production** - Configure SSL/TLS for your web server

## 📝 API Endpoints

Currently, Maunabung is a server-rendered application without a REST API. All interactions happen through form submissions and page loads.

## 🐛 Troubleshooting

### Database Connection Failed
```
Solution: Verify MySQL is running and credentials in config/database.php are correct
```

### Routes Return 404
```
Solution: Enable mod_rewrite on Apache, ensure .htaccess files exist
```

### Balance Discrepancies
```
Solution: Run reconciliation through AccountingService::reconcileBalance()
```

### Session Issues
```
Solution: Check PHP session configuration and permissions
```

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📧 Support

For issues, questions, or suggestions:
- Open an issue on GitHub
- Contact the development team

---

**Built with ❤️ for better financial management**

*Maunabung - Save and grow your money wisely*
