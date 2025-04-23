# 📌 Plain PHP Project

## 📖 Overview
Plain PHP Project that serves as a backend for web and mobile applications. It includes essential configurations, middleware, and routes.

## ✨ Features
- ✅ RESTful API endpoints  
- ✅ Middleware support (CORS, body-parser, etc.)  
- ✅ Environment variable configuration  
- ✅ Logging and error handling  


## 📥 Installation
1. **Clone the repository:**  
   ```sh
   git 
   ```
2. **Navigate to the project directory:**  
   ```sh
   cd 
   ```
3. **Install dependencies:**  
   ```sh
   composer install
   ```
   

## ⚙️ Configuration
Create a `.env` file in the project root and add necessary environment variables:  
```env
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

## 🚀 Running the Project
- **Start the development server:**  
  ```sh
  php -S localhost:8000 router.php
  ```

## 🛠️ Database Migrations & Seeders
- **Create config migration:**  
  ```sh
  vendor/bin/phinx create CreateUsersTable
  ```
- **Make migration:**  
  ```sh
  vendor/bin/phinx create CreateTestTable
  ```
- **Run migration:**  
  ```sh
  vendor/bin/phinx migrate
  ```
- **Make seeder:**  
  ```sh
  vendor/bin/phinx seed:create UserSeeder
  ```
  - **Run seeder:**  
  ```sh
  vendor/bin/phinx seed:run
  ```
## 📂 Folder Structure
```
.
├── api/         # Api files
├── middleware/     # Custom middleware
├── controller/     # Controller functions
├── model/         # Database models
├── vendor/         # Packages installed
├── .env           # Environment variables
├── .gitignore     # Ignored files
├── server.js      # Main server file
└── composer.json   # Project metadata
```


