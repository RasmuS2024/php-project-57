

### Hexlet tests and linter status:
[![Actions Status](https://github.com/RasmuS2024/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/RasmuS2024/php-project-57/actions)

### SonarQube quality status:
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=RasmuS2024_php-project-57&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=RasmuS2024_php-project-57)

### Project on render.com:
https://php-project-57-42yp.onrender.com

### Prerequisites
* Linux, WSL
* PHP >= 8.2
* Node.js & npm
* SQLite (for local development)
* PostgreSQL (for production)
* Composer
* Make
* Git

### Setup
```bash
git clone https://github.com/RasmuS2024/php-project-57.git
cd php-project-9
make install
```

### Start and use
You must define the DATABASE_URL environment variable according to the parameters of your PostgreSQL database ("user", "password" and "db_name").
```bash
export DATABASE_URL='postgresql://user:password@localhost:5432/db_name'
make start
```
At http://localhost:8000 the Page Analyzer will start.
The IP address and port are configured in the Makefile