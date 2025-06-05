# Automatically login

# Why
At staging, it's required to impersonate a guest to test the software. This package allows you to impersonate a guest by visiting a specific route.

# Installation
You can install the package via composer:

```bash
composer require silaswint/laravel-impersonate-guest
```

If you want to publish the config file, run this command:

```bash
ddev artisan impersonate-guest:install 
```

Add this interface to your User Model:

```php
class User implements \Silaswint\LaravelImpersonateGuest\App\Interfaces\HasImpersonateGuest
```

# Configuration
To enable guest impersonation, add this to your .env file:

```dotenv
IMPERSONATE_GUEST_ENABLED=true
```

Add this to your app/Http/Kernel.php:

```php
protected $middlewareGroups = [
    'web' => [
        // other middlewares...
        \Silaswint\LaravelImpersonateGuest\App\Http\Middleware\ImpersonateGuest::class,
    ];
];
```

# Usage
Now you can impersonate a guest by visiting the route /impersonate-guest-start and stop impersonating by visiting /impersonate-guest-end.

In your middleware which is responsible for redirecting to the login page, you can check if the user is impersonating a guest:

```php
    public function handle($request, Closure $next)
    {
        if (auth()->check() || isImpersonatingGuest()) {
            return $next($request);
        }

        return redirect()->route('login');
    }
```

# Customization
If you want to build your own UI, you can use the following example:

```vue
<template>
  <div
      v-if="canImpersonateGuest || isImpersonatingGuest"
      class="w-full bg-gray-100 py-2 text-center text-sm"
  >
    <span v-if="!isImpersonatingGuest">
      <a
          class="text-blue-600 cursor-pointer hover:underline"
          @click="impersonateGuestStart"
      >
        Act as guest
      </a>
    </span>
    <span v-else>
      <a
          class="text-red-600 cursor-pointer hover:underline"
          @click="impersonateGuestEnd"
      >
        Stop acting as guest
      </a>
    </span>
  </div>
</template>
<script setup>
  import { computed } from 'vue'
  import axios from 'axios'
  import { usePage } from '@inertiajs/vue3'
  import route from 'ziggy-js'

  const page = usePage()

  const isImpersonatingGuest = computed(() => page.props.isImpersonatingGuest)
  const canImpersonateGuest = computed(() => page.props.canImpersonateGuest)

  const impersonateGuestStart = () => {
    axios.post(route('impersonate-guest-start')).then(() => {
      window.location.reload()
    })
  }

  const impersonateGuestEnd = () => {
    axios.post(route('impersonate-guest-end')).then(() => {
      window.location.reload()
    })
  }
</script>
```
