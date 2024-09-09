# Task Management API

This is a RESTful API built with Lumen for managing tasks with basic CRUD (Create, Read, Update, Delete) operations. It includes functionality for creating, updating, deleting, and retrieving tasks with filtering and pagination options.

## Requirements

- PHP >= 7.3
- PostgreSQL database
- Composer

## Features

- **Task Management**: Create, update, delete, and retrieve tasks.
- **Filtering**: Filter tasks by `status` and `due_date`.
- **Search**: Search tasks by `title`.
- **Pagination**: Paginate task listings with 10 items per page.
- **Validation**: Enforces validation rules for task creation and updates.

## Task Model

- `id`: UUID
- `title`: String, required, unique
- `description`: Text, optional
- `status`: Enum (`pending`, `in-progress`, `completed`), defaults to `pending`
- `due_date`: Date, must be a future date
- `created_at`: Timestamp
- `updated_at`: Timestamp
- `deleted_at`: Timestamp (soft delete)

## API Endpoints

### **POST** `/api/tasks`

Create a new task.

**Request Body:**

```json
{
  "title": "Finish project report",
  "description": "Complete the final report for the project.",
  "status": "in-progress",
  "due_date": "2024-09-30"
}
```

**Response:**

```json
{
  "id": "e8f7c3b4-5c2d-4d08-85b3-3c9b7d3a6e5e",
  "title": "Finish project report",
  "description": "Complete the final report for the project.",
  "status": "in-progress",
  "due_date": "2024-09-30",
  "created_at": "2024-09-01T12:00:00Z",
  "updated_at": "2024-09-01T12:00:00Z",
  "deleted_at": null
}
```

### **GET** `/api/tasks`

Retrieve all tasks with optional filtering and pagination.

**Query Parameters:**

- `status` (optional): Filter tasks by status.
- `due_date` (optional): Filter tasks by due date.
- `search` (optional): Search tasks by title.

**Example Request:**

```
GET /api/tasks?status=in-progress&search=report
```

**Response:**

```json
{
  "current_page": 1,
  "data": [
    {
      "id": "e8f7c3b4-5c2d-4d08-85b3-3c9b7d3a6e5e",
      "title": "Finish project report",
      "description": "Complete the final report for the project.",
      "status": "in-progress",
      "due_date": "2024-09-30",
      "created_at": "2024-09-01T12:00:00Z",
      "updated_at": "2024-09-01T12:00:00Z",
      "deleted_at": null
    }
  ],
  "first_page_url": "http://localhost:8000/api/tasks?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://localhost:8000/api/tasks?page=1",
  "next_page_url": null,
  "path": "http://localhost:8000/api/tasks",
  "per_page": 10,
  "prev_page_url": null,
  "to": 1,
  "total": 1
}
```

### **GET** `/api/tasks/{id}`

Retrieve a specific task by ID.

**Example Request:**

```
GET /api/tasks/e8f7c3b4-5c2d-4d08-85b3-3c9b7d3a6e5e
```

**Response:**

```json
{
  "id": "e8f7c3b4-5c2d-4d08-85b3-3c9b7d3a6e5e",
  "title": "Finish project report",
  "description": "Complete the final report for the project.",
  "status": "in-progress",
  "due_date": "2024-09-30",
  "created_at": "2024-09-01T12:00:00Z",
  "updated_at": "2024-09-01T12:00:00Z",
  "deleted_at": null
}
```

### **PUT** `/api/tasks/{id}`

Update an existing task.

**Request Body:**

```json
{
  "title": "Finish project report updated",
  "description": "Update the final report for the project.",
  "status": "completed",
  "due_date": "2024-09-15"
}
```

**Response:**

```json
{
  "id": "e8f7c3b4-5c2d-4d08-85b3-3c9b7d3a6e5e",
  "title": "Finish project report updated",
  "description": "Update the final report for the project.",
  "status": "completed",
  "due_date": "2024-09-15",
  "created_at": "2024-09-01T12:00:00Z",
  "updated_at": "2024-09-01T12:30:00Z",
  "deleted_at": null
}
```

### **DELETE** `/api/tasks/{id}`

Delete a task.

**Example Request:**

```
DELETE /api/tasks/e8f7c3b4-5c2d-4d08-85b3-3c9b7d3a6e5e
```

**Response:**

```json
{
  "message": "Task deleted successfully"
}
```

## Setup Instructions

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

5. **Seed the database** (Optional):

   To populate the database with sample data, run:

   ```bash
   php artisan db:seed
   ```

6. **Serve the application**:

   Start the Lumen server:

   ```bash
   php -S localhost:8000 -t public
   ```

## Validation

The API enforces strict validation to ensure correct data types and required fields:

- **Title**: Must be unique and required.
- **Due Date**: Must be a future date.
- **Status**: Defaults to `pending` if not specified.
