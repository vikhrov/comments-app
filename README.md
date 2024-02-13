### Установка и запуск проекта

1. **Установите Docker:** Если у вас еще нет Docker, скачайте и установите его с [официального сайта Docker](https://www.docker.com/get-started).

2. **Скачайте контейнер проекта и запустите его:**
   ```sh
   docker run --rm -v $(pwd):/app -w /app ghcr.io/vikhrov/comments-app:comment-app sh -c "npm install && npm run dev"
3. **Открыть браузер и перейти по адресу http://localhost:8080**
