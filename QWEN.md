# Maunabung - Project Context

## Project Overview

**Maunabung** is a personal finance management web application built with **vanilla PHP** (no framework), **MySQL**, and **Bootstrap 5**. The application provides comprehensive financial tracking with a focus on accounting integrity, audit trails, and data security.

### Core Features
- **User Management**: Registration, login, and profile settings with currency preferences
- **Dashboard**: Financial summaries, expense charts, and recent activity
- **Transactions**: Income/expense tracking with date and category filtering
- **Double-Entry Lite System**: ACID-compliant transaction logic preventing balance errors
- **Audit Trail**: Complete logging of all data changes with encryption
- **Categories**: Custom income/expense categories with color labels
- **Reports**: Periodic financial summaries with CSV export
- **Budget & Goals**: Budget tracking and savings goal management
- **Salary Allocator**: Income distribution planning

## Technology Stack

| Component | Technology |
|-----------|------------|
| Backend | PHP 7.4+ (Recommended 8.1+) |
| Database | MySQL / MariaDB (InnoDB required) |
| Frontend | Bootstrap 5, Vanilla JS |
| Architecture | MVC Pattern |
| Server | Apache/Nginx or PHP Built-in Server |

### Required PHP Extensions
- `pdo` - Database abstraction layer
- `bcmath` - Precision arithmetic for financial calculations

## Project Structure

```
maunabung/
├── app/
│   ├── Controllers/        # Request handlers (10 controllers)
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
│   │   ├── Router.php      # Simple routing system
│   │   ├── Model.php       # Base model with CRUD
│   │   ├── View.php        # Template renderer
│   │   └── Security.php    # CSRF, XSS, encryption
│   ├── Models/             # Database interaction layer
│   │   ├── User.php
│   │   ├── Transaction.php
│   │   ├── Category.php
│   │   ├── Account.php
│   │   ├── SavingsGoal.php
│   │   ├── Settings.php
│   │   └── AuditLog.php
│   ├── Services/           # Business logic layer
│   │   └── AccountingService.php  # Core financial logic
│   └── Views/              # HTML templates (Bootstrap 5)
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
│       ├── layouts/        # Header, footer, navigation
│       └── 404.php
├── config/
│   └── database.php        # DB configuration
├── db/
│   ├── schema.sql          # Database schema
│   └── migrations/         # Database migrations
├── public/                 # Web root directory
│   ├── index.php           # Application entry point
│   ├── .htaccess           # URL rewriting
│   └── assets/             # CSS, JS, images
├── utils/
│   └── backup.php          # Database backup utility
├── .htaccess               # Root URL rewriting to /public
└── README.md
```

## Building and Running

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd maunabung
   ```

2. **Create Database**
   ```sql
   CREATE DATABASE maunabung;
   ```

3. **Import Schema**
   ```bash
   mysql -u root -p maunabung < db/schema.sql
   ```
   
   Also run migrations if available:
   ```bash
   mysql -u root -p maunabung < db/migrations/001_accounting_hardening.sql
   ```

4. **Configure Database**
   Edit `config/database.php`:
   ```php
   return [
       'host' => 'localhost',
       'dbname' => 'maunabung',
       'username' => 'root',
       'password' => '',
       'charset' => 'utf8mb4'
   ];
   ```

5. **Run Application**
   ```bash
   php -S localhost:8000 -t public
   ```
   Access at: `http://localhost:8000`

### Apache/Nginx Deployment

The project uses `.htaccess` for URL rewriting:
- Root `.htaccess`: Redirects all traffic to `/public`
- `public/.htaccess`: Front controller pattern for routing

Ensure `mod_rewrite` is enabled on Apache.

## Architecture Patterns

### MVC Implementation
- **Router**: Simple pattern-matching router in `App\Core\Router`
- **Controllers**: Handle HTTP requests, invoke services, render views
- **Models**: Extend `App\Core\Model`, handle database operations
- **Services**: Business logic layer (e.g., `AccountingService`)
- **Views**: PHP templates with Bootstrap 5

### Key Design Patterns
1. **Singleton**: `Database` class ensures single DB connection
2. **Service Layer**: `AccountingService` encapsulates financial logic
3. **Repository Pattern**: Models abstract database operations
4. **Front Controller**: All requests through `public/index.php`

### Autoloading
PSR-4 style autoloader in `index.php`:
```php
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    // ... loads App\* classes
});
```

## Development Conventions

### Coding Standards
- **Namespace**: `App\Controllers`, `App\Models`, `App\Services`, `App\Core`
- **Naming**: PascalCase for classes, camelCase for methods/variables
- **File Naming**: Match class names (e.g., `UserController.php`)
- **Type Handling**: Use `bcmath` for all monetary calculations

### Security Practices
1. **Password Hashing**: Bcrypt via `Security::hashPassword()` / `verifyPassword()`
2. **SQL Injection Prevention**: Prepared statements (PDO)
3. **XSS Prevention**: `esc()` helper function for output escaping
4. **CSRF Protection**: Token validation on POST requests
5. **Audit Logging**: All mutations logged in `audit_logs` table
6. **Soft Deletes**: Transactions marked as deleted, not removed

### Accounting Principles
1. **ACID Compliance**: All financial operations wrapped in transactions
2. **Double-Entry Lite**: Every transaction affects accounts consistently
3. **Lock Date**: Prevent modifications to closed accounting periods
4. **Reconciliation**: Automated balance validation and correction
5. **Audit Trail**: Encrypted before/after values for all changes

### Database Conventions
- **Primary Keys**: `id` (auto-increment)
- **Timestamps**: `created_at`, `updated_at` on all tables
- **Soft Delete**: `deleted_at` for transactions
- **Foreign Keys**: Explicit constraints with `fk_` prefix
- **JSON Columns**: `old_values`, `new_values` in audit_logs

## Key Business Logic

### Transaction Types
| Type | Description | Balance Impact |
|------|-------------|----------------|
| `income` | Money received | +account balance |
| `expense` | Money spent | -account balance |
| `transfer` | Between accounts | -source, +destination |
| `adjustment` | Balance correction | ±account balance |

### AccountingService Methods
- `recordTransaction()`: Create transaction with ACID guarantees
- `updateTransaction()`: Modify with balance recalculation
- `deleteTransaction()`: Soft delete with balance revert
- `reconcileBalance()`: Fix discrepancies via adjustment entries
- `validateConfiguration()`: Verify balance integrity

## Testing Practices

Currently no automated test suite. Manual testing recommended for:
1. Transaction creation and balance updates
2. Transfer operations between accounts
3. Soft delete and balance reversion
4. Audit log completeness
5. Lock date enforcement

## Common Tasks

### Add New Controller
```php
// app/Controllers/NewController.php
namespace App\Controllers;

class NewController {
    public function index() {
        // Render view
    }
}
```

### Add New Route
In `public/index.php`:
```php
$router->add('GET', '/new-route', 'NewController', 'index');
```

### Add New Model
```php
// app/Models/NewModel.php
namespace App\Models;

use App\Core\Model;

class NewModel extends Model {
    protected $table = 'new_table';
    
    // Custom methods
}
```

### Database Migration
Create SQL file in `db/migrations/` with descriptive prefix:
```sql
-- db/migrations/002_feature_name.sql
ALTER TABLE users ADD COLUMN new_column VARCHAR(100);
```

## Known Constraints

1. **No ORM**: Raw SQL in models (intentional for simplicity)
2. **No Frontend Framework**: Vanilla JS + Bootstrap only
3. **No Queue System**: Synchronous processing only
4. **No Caching Layer**: Direct database queries
5. **Session-based Auth**: PHP native sessions

## Troubleshooting

### Database Connection Failed
- Verify MySQL service is running
- Check credentials in `config/database.php`
- Ensure database `maunabung` exists

### Routes Not Working
- Confirm `.htaccess` files are present
- Enable `mod_rewrite` on Apache
- Check `RewriteBase` if in subdirectory

### Balance Discrepancies
- Run reconciliation via `AccountingService::reconcileBalance()`
- Review `audit_logs` for anomalies
- Verify `bcmath` extension is loaded

## References

- **README.md**: User-facing documentation
- **db/schema.sql**: Complete database structure
- **app/Core/**: Framework foundation classes
- **app/Services/AccountingService.php**: Core financial logic
