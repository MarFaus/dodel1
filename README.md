# 📚 Практическая работа №38: Информационная система «Библиотека» (Laravel 13)

Развитая информационная система для учета книжного фонда, авторов, читателей и журнала выдачи/возврата книг. Проект выполнен в рамках практической работы №38 (дополнительное расширение функционала с реляционной базой данных).

---



 ([MarFaus](https://github.com/MarFaus))

* Репозиторий: [38zadaniedonaDOP](https://github.com/MarFaus/38zadaniedonaDOP.git)

---

## 🚀 Основные возможности системы

* **📊 Панель управления (Dashboard):** Сводные карточки ключевых метрик (общее число книг, авторов, зарегистрированных читателей, книг на руках и возвратов) и таблица последних операций.
* **📖 Каталог книг (Book CRUD):** 
  * Учет книг с привязкой к авторам через связи Eloquent (`belongsTo`).
  * Поиск по названию, жанру, ISBN и автору.
  * Фильтрация книг по жанру и автору.
  * Динамический контроль остатка экземпляров (автоматический пересчёт доступного количества при выдаче).
* **✍️ Справочник авторов (Author CRUD):** 
  * Ведение базы авторов (ФИО, дата рождения, страна, биография).
  * Просмотр полного списка книг каждого автора (`hasMany`).
* **👥 Реестр читателей (Reader CRUD):**
  * Учет читателей с контактными данными (телефон, email, дата рождения).
  * Персональная карточка читателя с историей всех взятых книг.
* **🔄 Журнал выдачи книг (Borrowing & Return):**
  * Оформление выдачи книг с выбором читателя и контролем доступного фонда.
  * Быстрый возврат книг в один клик с отметкой даты фактического возврата (`returned_at`).
  * Фильтрация выдач по статусам (`На руках` / `Возвращена`).

---

## 🛠 Технологический стек

* **PHP:** ^8.2 / 8.5+
* **Laravel Framework:** 13.x
* **База данных:** SQLite / MySQL / PostgreSQL (с каскадными внешними ключами `cascadeOnDelete`)
* **Шаблонизатор:** Blade (чистый адаптивный CSS, гарнитура Inter, цветовая индикация статусов)
* **Архитектура:** MVC + Eloquent Relationships

---

## 🏛 Схема базы данных (Relationships)

Author (1)
       │
       │ hasMany
       ▼
    Book (1) ─── hasMany ───► Borrowing (*)
                                 ▲
                                 │ belongsTo
                             Reader (1)

1. **`authors`** `(id, name, birth_date, country, biography)`
2. **`books`** `(id, title, author_id, genre, year, isbn, quantity, available, description)`
3. **`readers`** `(id, full_name, phone, email, birth_date)`
4. **`borrowings`** `(id, book_id, reader_id, borrowed_at, return_date, returned_at, status)`

---

## 📁 Структура ключевых файлов проекта

```text
C:\Zadania_doma\38GM
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthorController.php      # Управление справочником авторов
│   │       ├── BookController.php        # Управление каталогом книг и поиском
│   │       ├── BorrowingController.php   # Выдача, возврат и учет остатков
│   │       ├── DashboardController.php   # Аналитика и главная страница
│   │       └── ReaderController.php      # Управление читательскими билетами
│   └── Models/
│       ├── Author.php                    # Модель автора (hasMany Book)
│       ├── Book.php                      # Модель книги (belongsTo Author, dynamic availability)
│       ├── Borrowing.php                 # Модель выдачи (belongsTo Book, Reader)
│       └── Reader.php                    # Модель читателя (hasMany Borrowing)
├── database/
│   ├── migrations/
│   │   ├── 2025_01_01_000001_create_authors_table.php
│   │   ├── 2025_01_01_000002_create_books_table.php
│   │   ├── 2025_01_01_000003_create_readers_table.php
│   │   └── 2025_01_01_000004_create_borrowings_table.php
│   └── seeders/
│       └── DatabaseSeeder.php            # Тестовые данные (авторы, книги, читатели, выдачи)
├── resources/
│   └── views/
│       ├── authors/                      # Шаблоны CRUD авторов (index, create, edit, show)
│       ├── books/                        # Шаблоны CRUD книг (index, create, edit, show)
│       ├── borrowings/                   # Шаблоны выдачи книг (index, create)
│       ├── readers/                      # Шаблоны CRUD читателей (index, create, edit, show)
│       ├── layouts/
│       │   └── app.blade.php             # Базовый макет с навигацией и стилями
│       └── dashboard.blade.php           # Аналитическая главная панель
└── routes/
    └── web.php                           # Маршруты веб-приложения


⚙️ Быстрый запуск проекта
Клонирование репозитория:

Bash
git clone [https://github.com/MarFaus/38zadaniedonaDOP.git](https://github.com/MarFaus/38zadaniedonaDOP.git)
cd 38zadaniedonaDOP
Установка зависимостей Composer (при необходимости):

Bash
composer install
Настройка окружения (.env):

Bash
cp .env.example .env
php artisan key:generate
Применение миграций и запуск сидеров (демо-данные):

Bash
php artisan migrate:fresh --seed
Запуск локального сервера:

Bash
php artisan serve
После запуска откройте браузер по адресу: http://127.0.0.1:8000.

📌 Команды для отправки изменений в Git
PowerShell
git add .
git commit -m "Docs: Обновлен README.md с описанием ИС Библиотека"
git push origin main