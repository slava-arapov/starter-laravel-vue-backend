# Laravel/Vue 2 Starter (Frontend)
This template is designed for a quick start of a new Laravel/Vue project.

The starter is decoupled into two parts:

-  [Backend Laravel API](https://github.com/slava-arapov/starter-laravel-vue-backend/) (you are here)
-  [Frontend Vue.js SPA](https://github.com/slava-arapov/starter-laravel-vue-frontend/)

## Features and Dependencies
* Laravel 9
* [Laravel Sail](https://laravel.com/docs/8.x/sail)
* [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum)
* [Laravel Fortify](https://laravel.com/docs/8.x/fortify)
* [Laravel Telescope](https://laravel.com/docs/8.x/telescope) is available for admins
* [Eloquent API Resources](https://laravel.com/docs/8.x/eloquent-resources) used to build API
* Image Processing using Intervention Image (Dockerfiles modified to install imagick extension)
* [PHPStan](https://phpstan.org/) / [Larastan](https://github.com/nunomaduro/larastan), [Psalm](https://psalm.dev/), [PHP Coding Standards Fixer](https://cs.symfony.com/) static code analysis tools

## System Requirements
* PHP >= 8.0.2
* PHP Extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, cURL, GD, Imagick
* Composer >= 1.9.x

## Project Setup
1. Clone the repository
   ``` bash
   git clone https://github.com/slava-arapov/starter-laravel-vue-backend.git
   cd starter-laravel-vue-backend
   ```

2. Copy your .env file for local development or production. Laravel Sail parameters are used by default
   ``` bash
   cp .env.example .env
   ```

3. Edit your .env file. Make sure to set these variables
   ``` dotenv
   APP_URL=http://localhost # local development
   APP_URL=https://api.yourappname.com # production

   DB_HOST=mysql # docker-compose, Laravel Sail environment
   DB_HOST=127.0.0.1 # local development and production
   DB_HOST=localhost # if you get an PDOException error
   
   DB_USERNAME=user
   DB_PASSWORD=password
   
   MEMCACHED_HOST=memcached # docker-compose, Laravel Sail environment
   MEMCACHED_HOST=127.0.0.1 # local development and production
   
   REDIS_HOST=redis # docker-compose, Laravel Sail environment
   REDIS_HOST=127.0.0.1 # local development and production
   
   MAIL_FROM_ADDRESS=mail@yourappname.com
   
   # Some Sanctum specific variables ↓
   SANCTUM_STATEFUL_DOMAINS=localhost:8080 # local development
   SANCTUM_STATEFUL_DOMAINS=yourappname.com # production
   
   SPA_URL=http://localhost:8080 # local development
   SPA_URL=https://yourappname.com # production
   
   SESSION_DOMAIN=localhost # local development
   SESSION_DOMAIN=.yourappname.com # production
   ```

4. Set your default admin credentials in `database\seeders\DatabaseSeeder.php`
5. Configure a [bash alias for Laravel Sail](https://laravel.com/docs/8.x/sail#configuring-a-bash-alias) in `.bashrc` file
   ``` shell
   alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
   ```
   
6. Change the image name for the `laravel.test` service in your application's `docker-compose.yml` file
7. Start Docker containers in background
   ``` shell
   sail up -d
   ```

8. Install dependencies and run some required commands
   ``` shell
   sail composer install
   sail artisan key:generate # to set APP_KEY value for encrypting and decrypting
   sail artisan storage:link # to use public storage disk
   sail artisan migrate --seed # to run migrations and seed admin user
   
   # OR
   composer install
   php artisan key:generate
   php artisan storage:link
   php artisan migrate --seed
   ```

### Run
``` shell
sail up -d
```

Now you can browse the site at http://localhost

### Stop
``` shell
sail stop
```

### Static Code Analysis Tools

You can run some tools 

``` shell
# PHPStan/Larastan
sail composer phpstan

# Psalm
sail composer psalm

# PHP Coding Standards Fixer (dry run)
sail composer php-cs-fixer-validate

# PHP Coding Standards Fixer (fix)
sail composer php-cs-fixer
```

You can customize scripts in `composer.json` and rules in `phpstan.neon`, `psalm.xml`, `.php-cs-fixer.php` config files. 

## Credits
This starter is designed using the instructions at https://laravelvuespa.com. I highly recommend to check out this resource and to support [@garethredfern](https://github.com/garethredfern).

## License
This starter is open-sourced software licensed under the [MIT license](LICENSE).
