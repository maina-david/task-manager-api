# Project: Simple API for Task Management

This is a RESTful API built with Lumen to manage tasks with basic CRUD (Create, Read, Update, Delete) operations.

## Requirements

- PHP >= 7.3
- PostgreSQL database
- Composer

### Features

- Create, update, delete, and retrieve tasks.
- Tasks can be filtered by `status` and `due_date`.
- Pagination and search functionality for task listings.

### Task Model

- `id`: Integer, auto-increment
- `title`: String, required, unique
- `description`: Text, optional
- `status`: Enum (pending, completed), defaults to pending
- `due_date`: Date, must be a future date
- `created_at`: Timestamp
- `updated_at`: Timestamp

### API Endpoints

- `POST /tasks`: Create a new task
- `GET /tasks`: Retrieve all tasks (with optional filtering and pagination)
- `GET /tasks/{id}`: Retrieve a specific task by ID
- `PUT /tasks/{id}`: Update an existing task
- `DELETE /tasks/{id}`: Delete a task

### Setup Instructions

1. **Clone the repository**:

   ```bash
   git clone https://github.com/maina-david/task-manager-api.git
   cd task-manager-api
   ```

2. **Install dependencies**:
   Run the following command to install all project dependencies via Composer:

   ```bash
   composer install
   ```

3. **Configure environment variables**:
   Create a `.env` file by copying the `.env.example`:

   ```bash
   cp .env.example .env
   ```

   Update the database configuration in the `.env` file to use PostgreSQL:

   ```bash
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Run database migrations**:
   Run the migration to create the `tasks` table:

   ```bash
   php artisan migrate
   ```

5. **Serve the application**:
   Start the Lumen server:

   ```bash
   php -S localhost:8000 -t public
   ```
  
### Validation

The API enforces strict validation to ensure the correct data types and required fields for each request:

- Tasks must have a unique `title`.
- `due_date` must be in the future.
- Status defaults to `pending`.
