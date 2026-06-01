# cvai - AI-Driven Resume Builder (Backend API)

`cvai` is a modern AI-powered platform for building and optimizing resumes based on desired job positions using artificial intelligence in 2026. This repository contains the backend of the project and its core APIs.

---

## 🛠 Technologies Used

- **Framework:** Laravel 11/12
- **Database:** PostgreSQL (with `pgvector` for future similarity search)
- **Authentication:** Laravel Sanctum (Token-based)
- **Architecture:** Action-Based Architecture (Domain-Driven Style)

---

## 🚀 Project Setup (Local Development)

### Requirements

- PHP >= 8.3
- Composer
- PostgreSQL

### Installation Steps

#### 1. Clone the project

```bash
git clone https://github.com/your-username/cvai-back.git
cd cvai-back
```

#### 2. Install dependencies

```bash
composer install
```

#### 3. Configure environment file

```bash
cp .env.example .env
```

Set PostgreSQL database credentials and AI service keys inside the `.env` file.

#### 4. Generate key and run migrations

```bash
php artisan key:generate
php artisan migrate --seed
```

#### 5. Run the server

```bash
php artisan serve
```

---

## 📂 Architecture Structure (Action-Based)

To follow Single Responsibility Principle, business logic is placed inside Actions layer:

```text
app/
├── Actions/
│   └── Resume/
│       ├── CreateResumeAction.php
│       └── OptimizeResumeAction.php
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ResumeController.php
│   │   └── AIController.php
```

---

## 🛣 API Documentation

All protected requests require the following header:

```
Authorization: Bearer {token}
```

### 🔓 Authentication (Public)

| Method | Endpoint        | Description                 |
| ------ | --------------- | --------------------------- |
| POST   | `/api/register` | Register new user           |
| POST   | `/api/login`    | Login and get Sanctum token |

### 🔐 Resume Management (Protected)

| Method | Endpoint                         | Description              |
| ------ | -------------------------------- | ------------------------ |
| GET    | `/api/user`                      | Get user info            |
| POST   | `/api/resumes`                   | Create new resume        |
| POST   | `/api/resumes/{resume}/optimize` | Optimize resume using AI |

---

## 🧪 Quick Test with Artisan Tinker

```bash
php artisan tinker
```

```php
$action = new \App\Actions\Resume\CreateResumeAction();
$action(['title' => 'Senior Developer Resume'], $userId = 1);
```

---

## 📜 Commit Standards

- `feat:` new feature
- `fix:` bug fix
- `refactor:` code refactoring without behavior change
- `docs:` documentation updates

---

> Commit: docs: add backend README with architecture and API structure
