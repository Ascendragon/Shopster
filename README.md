# Laravel Livewire Products

Управление товарами на Laravel + Livewire (CRUD).

## Установка

1. Клонируй репозиторий:
    ```
    git clone https://github.com/Ascendragon/Shopster.git
    cd Shopster
    ```

2. Установи зависимости:
    ```
    composer install
    npm install
    ```

3. Скопируй файл настроек окружения и сгенерируй ключ:
    ```
    cp .env.example .env
    php artisan key:generate
    ```

4. Настрой .env под свою базу данных:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=products_db
    DB_USERNAME=ТВОЙ_ПОЛЬЗОВАТЕЛЬ
    DB_PASSWORD=ТВОЙ_ПАРОЛЬ
    ```

5. Прогоняй миграции:
    ```
    php artisan migrate
    ```
### Заполнение таблицы категорий (seeder)

После миграции заполни тестовые данные:
```bash
php artisan db:seed --class=FactorySeeder

6. Запусти проект:
    ```
    php artisan serve
    ```

7. Открой в браузере:
    ```
    http://127.0.0.1:8000
    ```

## Полезное

- Для корректной работы Livewire убедись, что подключены `@livewireStyles` и `@livewireScripts` в layout.
- Чтобы добавить тестовые данные: используй сиды или создай вручную через интерфейс.
