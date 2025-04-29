# Mariale098 Quotes Package

A Laravel package for interacting with the DummyJSON Quotes API. This package provides a simple way to fetch and display quotes with caching and rate limiting.

## Installation

1. Create a new Laravel project:

```bash
composer create-project laravel/laravel [project-name]
```

2. Install the package via Composer:

```bash
composer require mariale098/quotes
```

3. Publish the configuration file:

```bash
php artisan vendor:publish --provider="Mariale098\Quotes\QuotesServiceProvider" --tag="config"
```

4. Publish the assets:

```bash
php artisan vendor:publish --provider="Mariale098\Quotes\QuotesServiceProvider" --tag="assets"
```

5. Publish the quotes-styles:

```bash
php artisan vendor:publish --provider="Mariale098\Quotes\QuotesServiceProvider" --tag="quotes-styles" --force
```

6. Configure your Laravel project's `.env` file with the following settings:

```bash
# Session Configuration
SESSION_DRIVER=file
# This setting stores session data in files, which is required for the quotes package to work properly

# Cache Configuration
CACHE_STORE=file
# This setting enables file-based caching for storing quotes data

# Queue Configuration
QUEUE_CONNECTION=sync
# This setting ensures that quote operations are processed synchronously
```

These settings are essential for the proper functioning of the quotes package, as they:
- Enable session management for user interactions
- Provide caching capabilities for API responses
- Ensure synchronous processing of quote operations

## Usage

### API Endpoints

The package provides the following API endpoints:

- `GET /api/quotes/random` - Fetches a random quote from the API
- `GET /api/quotes` - Retrieves a paginated list of quotes (supports `limit` and `skip` parameters)
- `GET /api/quotes/{id}` - Gets a specific quote by its ID

### Vue Component Integration

The package includes a Vue.js component for displaying quotes. Follow these steps to integrate it into your application:

7. Update your `welcome.blade.php` view to include the Vue app container and necessary assets:

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Quotes</title>
        @vite(['resources/css/app.css'])
    </head>
    <body>
        <div id="app"></div>
        @vite(['resources/js/app.js'])
    </body>
</html>
```

8. Import and mount the component in your `resources/js/app.js`:

```javascript
import { createApp } from 'vue';
import QuotesComponent from './components/QuotesComponent.vue';

createApp(QuotesComponent).mount("#app");
```

9. Configure Vite by updating your `vite.config.js`:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
});
```

10. Install Vue.js dependencies and build the assets:

```bash
npm install @vitejs/plugin-vue vue
npm run build
```

11. Start the Laravel development server to test your application:

```bash
php artisan serve
```

## Features

- **Random Quote Display**: Shows a random quote that changes on page reload
- **Quote Search**: Search for quotes by their ID
- **Paginated Quotes List**: Browse through quotes with pagination
- **Error Handling**: User-friendly error messages
- **Responsive Design**: Mobile-friendly interface
- **Caching**: Built-in caching for API responses
- **Rate Limiting**: Protection against API abuse

## Configuration

Customize the package behavior by modifying the `config/quotes.php` file:

```php
return [
    'cache_ttl' => 3600, // Cache time in seconds (1 hour)
    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 50, // Maximum API calls per minute
        'decay_minutes' => 1,
    ],
];
```

## Author

Maria Alejandra Garcia Raiola (marialejandra.g98@gmail.com)
