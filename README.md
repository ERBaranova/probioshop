# БиоЧист — Интернет-магазин Chrisal

PHP + Flat Files (JSON), без базы данных.

## Быстрый старт

### 1. Разместить файлы
Document root сервера → папка `public/`

```
probioshop/
├── public/         ← document root (index.php, .htaccess, css, js)
├── src/            ← PHP-код (недоступно из браузера)
├── data/           ← JSON-файлы (недоступно из браузера)
└── config/         ← конфиг
```

### 2. Установить пароль админа

В `config/config.php` замени `ADMIN_PASSWORD_HASH` на хеш своего пароля:

```bash
php -r "echo password_hash('твой_пароль', PASSWORD_BCRYPT);"
```

Скопируй результат в конфиг:
```php
define('ADMIN_PASSWORD_HASH', '$2y$10$...');
```

### 3. Права на папки data/

```bash
chmod -R 755 data/
```

### 4. Apache — mod_rewrite должен быть включён

```apache
AllowOverride All
```

---

## Доступ

| URL | Что |
|-----|-----|
| `/` | Главная страница |
| `/catalog` | Каталог товаров |
| `/admin` | Панель администратора |
| `/admin/login` | Вход в админку |

**Демо-доступ к админке:** логин `admin`, пароль нужно сгенерировать (см. выше).

---

## Структура данных

| Файл | Содержимое |
|------|------------|
| `data/products/products.json` | Все товары |
| `data/products/categories.json` | Категории |
| `data/orders/orders.json` | Заказы |
| `data/users/users.json` | Пользователи |
| `data/products/reviews.json` | Отзывы (опционально) |

---

## Этапы разработки

- [x] Этап 1 — Структура, роутер, модели
- [x] Этап 2 — Каталог, страница товара, корзина, заказы, кабинет
- [x] Этап 3 — Админ-панель
- [ ] Этап 4 — SEO, кеш, подготовка к оплате (ЮКасса)

---

## Деплой через GitHub

### Первый раз на хостинге (через SSH или терминал хостинга)

```bash
# Переходим в папку сайта
cd ~/public_html   # или как называется на твоём хостинге

# Клонируем репозиторий
git clone https://github.com/ТВО_ИМЯ/probioshop.git .

# Права на папку data
chmod -R 755 data/

# Создаём пустые JSON если их нет
[ ! -f data/orders/orders.json ] && echo "[]" > data/orders/orders.json
[ ! -f data/users/users.json ]   && echo "[]" > data/users/users.json
[ ! -f data/b2b/leads.json ]     && echo "[]" > data/b2b/leads.json
```

### Настройка автодеплоя (GitHub Webhook)

1. Открой репозиторий на GitHub
2. Settings → Webhooks → Add webhook
3. Payload URL: `https://ВАШ_ДОМЕН/deploy.php`
4. Content type: `application/json`
5. Secret: придумай строку (например `mys3cr3t_k3y`)
6. Events: Just the push event
7. В `public/deploy.php` замени `DEPLOY_SECRET` на ту же строку
8. В `public/deploy.php` замени `REPO_PATH` на путь к папке на хостинге

### Дальнейшая работа

Теперь каждый раз когда мы с Клодом вносим изменения:
1. Клод обновляет файлы в твоём репозитории
2. Ты делаешь `git push` (или через GitHub Desktop)
3. Хостинг автоматически подтягивает изменения через webhook

### Не забудь после клонирования

```bash
# Сменить пароль админки
php -r "echo password_hash('твой_пароль', PASSWORD_BCRYPT);"
# Вставить результат в config/config.php → ADMIN_PASSWORD_HASH

# Поменять APP_URL в config/config.php
# APP_URL = 'https://ВАШ_ДОМЕН'
```
