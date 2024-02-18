# How to install project

1. At first you need to clone project from get repository
```bash
git clone https://github.com/vikhrov/comments-app.git
```
2. Navigate to the project directory
```bash
cd comments-app
```

4. Make `.env` file and set needed variables
```bash
cp .env.example .env
```
5. Start Docker containers
```bash
docker-compose up -d
```

3. Install Node.js dependencies
```bash
docker-compose exec laravel.test npm install
```

6. Install Composer dependencies
```bash
docker-compose exec laravel.test composer install
```
6. docker-compose exec laravel.test php artisan key:generate

7. docker-compose exec laravel.test php artisan storage:link

7. Run database migrations and seeder
```bash
docker-compose exec laravel.test php artisan migrate:fresh --seed --class=CommentsSeeder
```

8. Open your browser and go to 'http://localhost'



