# Portfolio System

Portfolio System written in Laravel & Vue to manage all your design & coding work at one place.

[Demo](http://137.184.42.245/)

## Features

- Fully tested backend
- Image optimizer
- REST API
- Admin Panel with Drag & Drop
- Automatically unzipping HTML websites and creating a demo

## Requirements

- php@7.1
- pngquant
- gifsicle
- jpegoptim

## Installation

1. Fork the Repo.
2. Run `touch database/database.sqlite`.
3. Run `php composer.phar install`.
4. Run `php artisan key:generate`.
5. Run `php artisan storage:link`.
6. Run `php artisan migrate`.
7. Run `php artisan jwt:secret`.
8. Run `php artisan tinker`.

Now will a new command line appear. Write the following to create a new admin account:

```
>>> $user = new App\User();
>>> $user->name = "YOUR NAME";
>>> $user->email = "YOUR EMAIL";
>>> $user->password = Hash::make("YOUR PASSWORD");
>>> $user->save();
>>> exit();
```

Done.

## Deployment

Use Laravel Forge for deployment.

## Usage

Run `php artisan serve`.
Then open `http://127.0.0.1:8000` for the website and `http://127.0.0.1:8000/admin` for the admin panel.

## API Endpoints

All API Endpoints can be found at `routes/api.php`. They all have a prefix therefore `login` is `api/login`, so the endpoint is `http://127.0.0.1:8000/api/login`.

## Troubleshoot

### File Size too Big

I had some websites which were bigger than 2M, therefore I had to increase the `upload_max_filesize` and `post_max_size` in my `php.ini`. If you do not know how to find your `php.ini`, you can open `server.php` then add `phpinfo();` to the body. Then run `php artisan serve` and open `http://127.0.0.1:8000`. You should see all your configurations also where `php.ini` is located. Open `php.ini` search for `upload_max_filesize` and `post_max_size` and increase both to something like `10M`. Finally remove `phpinfo();` from `server.php`.

If you are using Laravel Forge, you can increase the `upload_max_filesize` and `post_max_size` directly on their webpage.

### Cannot access readonly database

In this case, you need to change the permission of the database. From the root execute the following commands:
```
chown www-data:www-data database
chown www-data:www-data database/database.sqlite
```