# Basic API

## Installation

- Create a database in MySQL/MariaDB then import users.sql
- Edit DB connection data in config/Database.php

Execute the following commands in the project root folder
```bash
composer install
composer dump-autoload
```

## Usage

- POST requests to /api/register with "name", "email" and "password" to create a new user
- POST requests to /api/login with "email" and "password" to get a token