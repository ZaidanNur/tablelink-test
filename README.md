# Tablelink Technical Test

A comprehensive user management and analytics dashboard application with external flight data integration.

## Tech Stack

- **Framework**: Laravel 12
- **Admin Panel**: FilamentPHP v5.1
- **Authorization**: spatie/laravel-permission v6.24
- **Authentication**: Laravel Sanctum v4.3
- **Database**: MySQL 8.0 (via Docker)
- **Containerization**: Docker & Docker Compose

## Architecture

This project follows an **API-First** approach with **Service Layer Pattern**:

- All business logic resides in `app/Services/`
- Services can be consumed by both REST API Controllers and Filament Widgets
- Clean separation between presentation layer and business logic

## Quick Start

### 1. Build and Start Docker Containers

```bash
docker-compose up -d --build
```

### 2. Install Dependencies (inside container)

```bash
docker-compose exec app composer install
docker-compose exec app npm install
```

### 3. Run Migrations and Seeders

```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

### 4. Access the Application

- **Web Application**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin

### Default Admin Credentials

- **Email**: admin@tablelink.test
- **Password**: password

## API Endpoints

### Public Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/register` | Register new user |
| POST | `/api/login` | User login |

### Protected Endpoints (requires `Authorization: Bearer {token}`)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/logout` | Logout user |
| GET | `/api/user` | Get current user |

### Admin Only Endpoints (requires Admin role)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/dashboard/stats` | Dashboard analytics |
| GET | `/api/users` | List users (paginated) |
| GET | `/api/users/{id}` | Show user |
| PUT | `/api/users/{id}` | Update user |
| DELETE | `/api/users/{id}` | Soft delete user |
| GET | `/api/flights` | Flight information |

## Testing

```bash
# Run all tests
docker-compose exec app php artisan test

# Run specific test file
docker-compose exec app php artisan test --filter=AuthenticationTest
```

## Project Structure

```
app/
├── Filament/
│   ├── Pages/          # Custom Filament pages
│   ├── Resources/      # Filament resources (CRUD)
│   └── Widgets/        # Dashboard widgets
├── Http/
│   ├── Controllers/
│   │   └── Api/        # REST API controllers
│   └── Requests/       # Form validation
├── Models/             # Eloquent models
└── Services/           # Business logic layer
    ├── AuthService.php
    ├── DashboardStatsService.php
    ├── FlightService.php
    └── UserService.php
```

## Features

1. **User Management**: CRUD operations with soft deletes
2. **Role-Based Access**: Admin and User roles with Spatie Permission
3. **Dashboard Analytics**: Line, Bar, and Pie charts
4. **Flight Information**: Mock data from Tiket.com (CGK → DPS)
5. **Self-Deletion Prevention**: Admins cannot delete themselves

## License

MIT License
