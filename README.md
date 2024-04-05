# CRUD Lokotani

CRUD Lokotani is a web application for managing user data. It allows users to perform CRUD operations (Create, Read, Update, Delete) on user records stored in a database.

## Installation

To run the CRUD Lokotani application locally, follow these steps:

### Prerequisites

- PHP >= 8.2
- Composer (https://getcomposer.org/download/)
- MySQL or any other compatible database
- Laravel Version 10

1. Create a copy of the .env.example file and rename it to .env:
cp .env.example .env

2. Update the .env file with your database configuration:
DB_CONNECTION=mysql(i used mysql)
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

3. Run the database migrations to create the necessary tables:
php artisan migrate (its inside the app/database/migration)

4. Serve the application:
php artisan serve
