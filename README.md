# Comments App

This is a web application for managing comments. It's built using Laravel and Docker.

## Features

- Dockerized environment: Easy setup and deployment using Docker.
- MySQL database: Persistent storage for comments data.

# How to install project

1. At first you need to clone project from get repository
```bash
git clone https://github.com/vikhrov/comments-app.git
```

2. Navigate to the project directory
```bash
cd comments-app
```

3. Make `.env` file and set needed variables
```bash
cp .env.example .env
```

4. Start Docker containers
```bash
docker-compose up -d
```

5. Install Composer dependencies
```bash
docker-compose exec laravel.test composer install
```

6. Install Node.js dependencies
```bash
docker-compose exec laravel.test npm install
```

7. Generate key
```bash
docker-compose exec laravel.test php artisan key:generate
```

8. Create a symbolic link
```bash
docker-compose exec laravel.test php artisan storage:link
```

9. Run database migrations and seeder
```bash
docker-compose exec laravel.test php artisan migrate:fresh --seed
```

10. Open your browser and go to 'http://localhost'



