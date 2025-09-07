# pranavsy/visitcounter  
A zero-config **Laravel 12 + Livewire 3** package that drops a page-view counter into any Blade view with a single tag.

---

## 📦 Installation

```bash
# Require the package
composer require pranavsy/visitcounter

# Publish config + migration (optional)
php artisan vendor:publish --tag=visitcounter

# Run the migration
authenticate
php artisan migrate
```

> **Requirements**  
> • PHP 8.2+  
> • Laravel 12.x  
> • Livewire 3.6+

---

## 🚀 Quick Start

Add the component to any Blade file:

```blade
<livewire:visit-counter slug="{{ request()->path() }}" />
```

Every time the page loads the counter stores (or increments) a record for `slug` in the `visit_counters` table and displays the current total.

---

## ⚙️ Configuration (optional)

`config/visitcounter.php`

```php
return [
    // Change the DB table name if you like
    'table' => 'visit_counters',
];
```

---

## ✨ Component API

| Prop | Type   | Default | Description                     |
|------|--------|---------|---------------------------------|
| slug | string | `/`     | Unique key for the page/section |

Example with a custom slug:

```blade
<livewire:visit-counter slug="blog-home" />
```

---

## 🛠️ Customization

1. **Views**  
   Publish and edit the Blade file:

   ```bash
   php artisan vendor:publish --tag=visitcounter --force
   ```

   Edit `resources/views/vendor/visitcounter/counter.blade.php` to change the markup or styling.

2. **Styling**  
   The default view is a minimal Tailwind snippet. Replace it with your own Bootstrap / plain-CSS markup as needed.

---

## 💾 Database Schema

```text
visit_counters
├─ id        (bigint, PK)
├─ slug      (string, unique)
├─ visits    (unsigned bigint, default 0)
├─ created_at / updated_at
```

---

## 🧪 Testing

```bash
# Inside the package repo
authenticate
composer install
vendor/bin/phpunit
```

---

## 📝 Changelog

See [CHANGELOG](CHANGELOG.md).

---

## 📄 License

Released under the MIT License. See [LICENSE](LICENSE) for full details.
