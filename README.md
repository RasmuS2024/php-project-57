# Task Manager (Laravel)
An educational project at the Hexlet School of Programming.
Task Manager is a task management system similar to https://www.redmine.org. It allows you to set tasks, assign performers, and change their statuses. Registration and authentication are required to work with the system.

Учебный проект в школе программирования Хекслет.
Task Manager – система управления задачами, подобная https://www.redmine.org. Она позволяет ставить задачи, назначать исполнителей и менять их статусы. Для работы с системой требуется регистрация и аутентификация.

### Project status

[![Hexlet tests and linter](https://github.com/RasmuS2024/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/RasmuS2024/php-project-57/actions)
[![SonarQube Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=RasmuS2024_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=RasmuS2024_php-project-57)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=RasmuS2024_php-project-57&metric=coverage)](https://sonarcloud.io/summary/new_code?id=RasmuS2024_php-project-57)

### Live demo
🌐 [View on Render.com](https://php-project-57-42yp.onrender.com)

## Requirements

- **System**: Linux or WSL (Windows Subsystem for Linux)
- **PHP** ≥ 8.2
- **Node.js** ≥ 16.x & npm
- **Database**:
  - SQLite (for development)
  - PostgreSQL (for production)
- **Tools**:
  - Composer
  - Make
  - Git

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/RasmuS2024/php-project-57.git
   cd php-project-57
   ```
2. Install dependencies and setup:
   ```bash
   make install
   ```
3. Configure environment:
   ```bash
   cp .env.example .env
   # Edit .env file with your database credentials (DB_CONNECTION)
   ```
   or set database connection (for PostgreSQL):
   ```bash
   export DATABASE_URL='postgresql://user:password@localhost:5432/db_name'
   ```

4. Build assets and setup database:
   ```bash
   npm run build
   php artisan migrate
   ```

5. Add test data to the database (tasks, task statuses and labels):
   ```bash
   php artisan db:seed
   ```

## Running the application
   ```bash
   make start
   ```

Access the application at:
http://localhost:8000 (port configure in Makefile)

## Additional commands

* Run tests:
   ```bash
   make test
   ```

* Check code style:
   ```bash
   make lint
   ```