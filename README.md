# EMS - Employee Management System

A full-featured Employee Management System built with **Laravel 13**, **Livewire 3**, **Volt**, **Tailwind CSS**, and **Spatie Laravel Permission** for role-based access control.

## Features

- **Dashboard** — Admin dashboard with key metrics (total employees, attendance, pending leave, overdue tasks, recent activities) and Employee dashboard with personal tasks, leave balance, and attendance calendar
- **Authentication** — Registration, login, email verification, password reset (Laravel Breeze Livewire stack)
- **Role-Based Access Control** — 4 roles (Admin, HR Manager, Department Manager, Employee) with 22 granular permissions across 8 modules
- **Employee Management** — Employee profiles linked to user accounts, departments, job titles, and hierarchical supervisor relationships
- **Department Management** — Multi-level department hierarchy with manager assignment
- **Attendance Tracking** — Daily check-in/check-out with status tracking (present, absent, late, half-day, holiday, weekend)
- **Leave Management** — Leave types with configurable days, paid/unpaid status, and document requirements; leave request submission and approval workflow
- **Task Management** — Task assignment with priority levels, status tracking, and progress monitoring
- **Activity Logging** — Automatic audit trail of user actions across the system
- **Reporting** — PDF generation (dompdf), data export capabilities
- **Image Processing** — Avatar upload and manipulation (Intervention Image)

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8.3, Laravel 13 |
| **Frontend** | Livewire 3.6, Volt 1.7, Tailwind CSS 3, Alpine.js |
| **Build** | Vite 7, PostCSS, Autoprefixer |
| **Auth** | Laravel Breeze (Livewire + Volt stack) |
| **RBAC** | Spatie Laravel Permission 7.4 |
| **Database** | SQLite (default), MySQL, MariaDB, PostgreSQL, SQL Server |
| **PDF** | DomPDF |
| **Images** | Intervention Image 3 |
| **Testing** | Pest 4, PHPUnit |

## Requirements

- PHP ^8.3
- Composer
- Node.js & NPM
- SQLite or MySQL

## Installation

```bash
# Clone the repository
git clone <repository-url> ems
cd ems

# Install PHP dependencies
composer install

# Install NPM dependencies
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Create SQLite database (if using SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Build frontend assets
npm run build
```

## Quick Start

```bash
# Start the development server
php artisan serve

# In a separate terminal, start Vite for hot-reloading
npm run dev
```

Visit `http://localhost:8000` and log in with demo credentials (see below).

## Demo Credentials

### Admin Users (from RolesAndPermissionsSeeder)

| Email | Password | Role | Permissions |
|-------|----------|------|-------------|
| `admin@ems.com` | `password` | Administrator | All 22 permissions |
| `hr@ems.com` | `password` | HR Manager | Employee CRUD, attendance, leave approval, reports |
| `manager@ems.com` | `password` | Department Manager | Employee view, task management, leave approval |
| `employee@ems.com` | `password` | Employee | Leave apply, attendance view, tasks view |

### Employee Accounts (from EmployeesSeeder)

| Email | Password | Employee | Department | Job Title |
|-------|----------|----------|------------|-----------|
| `alice@ems.com` | `password` | Alice Chen | Engineering | Senior Software Engineer |
| `bob@ems.com` | `password` | Bob Martinez | Engineering | Junior Software Engineer |
| `carol@ems.com` | `password` | Carol Johnson | Human Resources | HR Manager |
| `david@ems.com` | `password` | David Kim | Marketing | Marketing Specialist |
| `eve@ems.com` | `password` | Eve Thompson | Finance | Financial Analyst |

## Architecture

### Database Schema

13 migrations creating 15 tables:

| Migration | Table(s) | Purpose |
|-----------|----------|---------|
| `0001_01_01_000000` | `users`, `password_reset_tokens`, `sessions` | Authentication |
| `0001_01_01_000001` | `cache`, `cache_locks` | Cache |
| `0001_01_01_000002` | `jobs`, `job_batches`, `failed_jobs` | Queue |
| `2026_05_21_003107` | `permissions`, `roles`, `model_has_*`, `role_has_*` | Spatie RBAC |
| `2026_05_21_004547` | `leave_types` | Leave type definitions |
| `2026_05_21_004548` | `departments` | Department hierarchy |
| `2026_05_21_004549` | `job_titles` | Job titles per department |
| `2026_05_21_004550` | `activity_logs` | Audit trail |
| `2026_05_21_004551` | `employees` | Employee profiles |
| `2026_05_21_004552` | `leave_requests` | Leave applications |
| `2026_05_21_004553` | `attendances` | Daily attendance records |
| `2026_05_21_004554` | `tasks` | Task assignments |
| `2026_05_21_044536` | `departments` (alter) | Manager FK |

### Models

9 Eloquent models with full relationships:

- **User** — HasOne Employee, HasRoles (Spatie)
- **Employee** — BelongsTo User/Department/JobTitle, HasMany Attendance/LeaveRequest/Task, self-referencing supervisor/subordinates
- **Department** — BelongsTo (parent), HasMany (children/employees/jobTitles), BelongsTo (manager)
- **JobTitle** — BelongsTo Department, HasMany Employees
- **LeaveType** — HasMany LeaveRequests
- **LeaveRequest** — BelongsTo Employee/LeaveType/User (reviewer), status workflow
- **Attendance** — BelongsTo Employee/User (marker), unique per employee per date
- **Task** — BelongsTo User (assigner)/Employee (assignee)/Department, priority/status workflow
- **ActivityLog** — BelongsTo User, polymorphic model reference

### Routes

| Method | URI | Component/View | Middleware | Description |
|--------|-----|---------------|------------|-------------|
| GET | `/` | `welcome` | guest | Landing page |
| GET | `/dashboard` | `AdminDashboard` | auth, verified | Admin stats dashboard |
| GET | `/employees` | `EmployeeDashboard` | auth, verified | Employee self-service |
| GET | `/users` | `admin.users` | auth, verified | User management (skeleton) |
| GET | `/profile` | `profile` | auth | Profile settings |
| GET | `/login` | `pages.auth.login` | guest | Login |
| GET | `/register` | `pages.auth.register` | guest | Registration |
| GET | `/forgot-password` | `pages.auth.forgot-password` | guest | Password reset |
| GET | `/reset-password/{token}` | `pages.auth.reset-password` | guest | Password reset form |
| GET | `/verify-email` | `pages.auth.verify-email` | auth | Email verification |
| GET | `/verify-email/{id}/{hash}` | `VerifyEmailController` | auth, signed | Verification link |
| GET | `/confirm-password` | `pages.auth.confirm-password` | auth | Confirm before sensitive actions |

### Role-Based Access Control

**4 Roles:**

| Role | Description |
|------|-------------|
| **admin** | Full system access — all 22 permissions |
| **hr_manager** | Employee management, attendance, leave approval, reports |
| **department_manager** | Employee view, task management, departmental leave approval |
| **employee** | Self-service: apply leave, view attendance, view tasks |

**22 Permissions across 8 modules:**

| Module | Permissions |
|--------|------------|
| Employees | view, create, edit, delete |
| Departments | view, create, edit, delete |
| Job Titles | view, create, edit, delete |
| Attendance | view, mark, edit |
| Leave | apply, view, approve, reject |
| Tasks | view, create, edit, delete, assign |
| Reports | view, export |
| Activity Logs | view |

### Livewire Components

| Component | View | Purpose |
|-----------|------|---------|
| `AdminDashboard` | `dashboard.blade.php` | Admin KPIs, recent activity feed |
| `EmployeeDashboard` | `employees/index.blade.php` | Personal tasks, leave balance, attendance calendar |
| `LoginForm` | (embedded in login page) | Authentication form with rate limiting |
| `Logout` | (action) | Session invalidation |

### Layouts & Components

- **`layouts/app.blade.php`** — Main authenticated layout with navigation bar, header slot, and content slot
- **`layouts/guest.blade.php`** — Guest layout for auth pages with centered card
- **`components/app-layout.php`** — Blade component class rendering `layouts.app`
- **17 Blade UI components** — buttons, dropdowns, modals, inputs, navigation links, error messages

## Seed Data

Running `php artisan db:seed` executes in order:

1. **RolesAndPermissionsSeeder** — 22 permissions, 4 roles, 4 user accounts
2. **LeaveTypesSeeder** — 6 leave types (Annual, Sick, Unpaid, Maternity, Paternity, Bereavement)
3. **EmployeesSeeder** — 5 departments, 5 job titles, 5 employees with user accounts

## Configuration

### Environment (.env)

Key configuration options in `.env`:

```env
APP_NAME=EMS
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel-ems
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Database

Default is SQLite. To switch to MySQL, update `.env` and uncomment the MySQL lines.

## Development

```bash
# Start both Laravel server and Vite hot-reload
php artisan serve
npm run dev
```

### Frontend Assets

- **CSS**: Tailwind CSS 3 with `@tailwindcss/forms` plugin
- **JavaScript**: Alpine.js (bundled with Livewire), Axios for HTTP
- **Build**: Vite 7 with `laravel-vite-plugin`

### Code Style

```bash
# Laravel Pint (PHP CS fixer)
./vendor/bin/pint
```

### Testing

```bash
# Run Pest tests
composer test
# or
php artisan test
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| `Target class [Livewire\...] does not exist` | Run `php artisan optimize` or `composer dump-autoload` |
| Migration foreign key error | Ensure `0001_01_01_000000` (users) runs first; run `php artisan migrate:fresh` |
| `The [pcntl] extension is required` for Pail | Install `ext-pcntl` or avoid using `php artisan pail` on Windows |
| Blank page after login | Run `npm install && npm run build` to compile frontend assets |
| Permission denied in storage | Set permissions: `chmod -R 775 storage bootstrap/cache` (Linux/Mac) |
