# Laravel 12 REST API – User Management

A simple Laravel 12-based REST API to perform CRUD operations on users and their associated email addresses

## Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/your-username/laravel-user-api.git
cd laravel-user-api
```

2. **Install dependencies**
```bash
composer install
```

3. **Create `.env` and configure**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Set up database**
```bash
php artisan migrate
```

5. **Run the local development server**
```bash
php artisan serve
```

6. **View mail logs**
> Laravel is set to `log` driver, check `storage/logs/laravel.log` for sent emails.

---

## API Endpoints & Usage

### Create a user
```bash
curl -X POST http://localhost:8000/api/users \
-H "Content-Type: application/json" \
-d '{
  "first_name": "John",
  "last_name": "Lennon",
  "phone": "123456789",
  "emails": [
    "john@example.com",
    "lennon@example.com"
  ]
}'
```

### Get all users
```bash
curl http://localhost:8000/api/users
```

### Get single user
```bash
curl http://localhost:8000/api/users/1
```

### Update user
```bash
curl -X PUT http://localhost:8000/api/users/1 \
-H "Content-Type: application/json" \
-d '{
  "first_name": "Johnny",
  "last_name": "Ono",
  "phone": "987654321",
  "emails": [
    "johnny@example.com"
  ]
}'
```

### Delete user
```bash
curl -X DELETE http://localhost:8000/api/users/1
```

### Send welcome emails
```bash
curl -X POST http://localhost:8000/api/users/1/send-welcome
```

---

## Project Structure Highlights

- `app/Models/User.php` – Defines user model and relationship to emails
- `app/Models/Email.php` – Defines email model and its inverse relationship
- `app/Http/Controllers/Api/UserController.php` – API logic
- `app/Mail/WelcomeUser.php` – Mail class to send user welcome messages
- `routes/api.php` – Defined routes
- `app/Http/Requests/StoreUserRequest.php` – Request validation for storing users
- `app/Http/Requests/UpdateUserRequest.php` – Request validation for updating users

---

## Notes

- API uses `api.php` route file, automatically prefixed with `/api/`
- Emails are not actually sent — they are logged into `storage/logs/laravel.log`
