## Customers

## Requirements
- Application made in laravel 10
- Local Server (Laragon, Xamp, etc...)
- Composer
- MySQL
- PHP ^8.1
- In case you do not have a local server, run the command (when installing dependencies):

```
php artisan serve
```
## Installation
Create database, run the following commands:
- Login to MySQL
```
mysql -u {USER} -p {PASSWORD}
```
- Or Default User
```
mysql -u root -p

```
- Create Data Base
```
mysql CREATE DATABASE customers;
```

- In the project folder, execute the following commands

Install project dependencies
```
composer install
```

Run migrations and seeders
```
php artisan migrate:fresh --seed
```

Install passport
```
php artisan passport:install

Note: Save the client secret: **** because it is the way our client will be verified when making the authentication request
```

## Additional notes:
- Soft deletes were used, so the "status" field with values like "t" or "trash" was no longer necessary.
- In the requirements, an authentication using SHA1 encryption is requested. I considered having two logins: the requested one and another one with Laravel Passport. However, due to the configuration of Laravel Passport, I couldn't perform the required authentication unless it was done in a more "manual" way, without using the tools provided by the framework.
- I chose to use Laravel Passport because I believe it is more efficient for an API that can have multiple clients. This tool provides us with the option to revoke tokens for both clients and users, and keeps a record of the user who logs in and the associated client.

I also consider SHA1 to be somewhat insecure these days. It would be better to choose something like SHA256, which is one of the algorithms used by Laravel Passport.


## Data Base Structure
<image src="https://adsnetlog.com/prueba-customers/db.png" alt="Descripción de la imagen">


I decided to keep the users table as the customers table, for "scalability" purposes and to avoid redundancy between tables. This way, if a customer needs to log in at any point, there won't be a need for any modifications. It would simply be a matter of granting them the necessary permissions for the actions they require.

A roles and permissions table was added. Currently, a customer can only access one endpoint, which is the greet endpoint. All other endpoints will only be accessible to administrator users.

# End Points

# Login
When executing "php artisan passport:install", it is necessary to save these two values: Password grant client
<image src="https://adsnetlog.com/prueba-customers/passport.png" alt="Descripción de la imagen">

```
POST /auth/token

body: {
    "client_id": 2,
    "client_secret": ********,
    "grant_type": "password",
    "username": "waylon74@example.com",
    "password": "password"
}

response: {
    {
        "success": true,
        "data": {
            "token_type": "Bearer",
            "expires_in": 604800,
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiZmZlYzYzMGU1MDJhOTRmMTE4MzUyMDMzM2E5NWE4M2Q4ZjQ3YWUzMmEwZWM5ZjVjZTgzZjE3YmU2YjU5YjIyYTBkYmNhMzliMThjOThiMDMiLCJpYXQiOjE2ODY0MjkxMDcuMDM1MTg3LCJuYmYiOjE2ODY0MjkxMDcuMDM1MTkxLCJleHAiOjE2ODcwMzM5MDcuMDIxODQzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.dwyp0pRTLPRUa-DtsRck9af-2XeLQY-7qGMOfzNgwiJZaZT7tFprm-yit-30krMjoh9nLmoB6rlVh8u54oFk7sU2-UR62jKLQ5ZFqwpwR0s7EzoktRgSidQO6k7YhBJwYWrXgyyZ-5_I2rrDZgmRd0kgRrOVIiBSB-XtFUsQZmUh4GrS91fJIK8ieO1Lu8FIsbo9zgf550RpVv6P8NBTqOvlvfKo-GYU9DBo0d0vuaPAJFJy6irtnWYoP4th1P70ch-VZ-jYxl94FDGyCPEsz3GzNa7wL5Of2yrh6yOGSm9KIqyf9PjWP9_xbbCE3-_NCEaAR9JxBG5O9nqE37MAW6RLADVSF4M6QR0HnimKn81jE9s0Q5b2yNAdbVcIgf80HFZ68q7syNOX4wAjf2YzUqXg9NXbjUL9oSekQbTFFZE7iuVonxubNyI4qb47llzgJsOniJAnm6SDBZPvneCQLn8D6d-STVmNSuLtRdwKAKVRrOxX_taGYz0ISX-c_ivMBuJitNzXvjKWKMozLHgjMJGtjToOBS1VfntHP-0PgMmyqZ24nje9l6ITV_1z2xi_vaUBxM4Mh_l1lBEEpmPltie3zwHxyWM_BwnyszW2PCwXydBpCP3FnB2inyZv_HYDsbHh0oP_5BttyIBXdm1ezVbcYUJt9fbGVedNNvfKQug",
            "refresh_token": "def50200c33be4dec32707e38264466af7f3d1143706babd9014305020f48a234cb32d30456588cc1dc1e4b51b4863f9be33a55ee8b2a41b494043a950da40015ac3b6b66d0038d6f2a2542ae7a1e2059107a209278c428ce27dad7d4a67f22d6482e26c99cc9cb146b9f28f2f0a6a9744232ce1f8ccd6b73f03facb4e4ca716c047281c48cb6dd5ab83c993f00a4f826e115775e1934f6ea4ee19fdbbe2ff3949964800df385c71d087c904471a799fafb63d131bbdd16f56b720419f213c5d55402014f468e60f84011b3c6cf40c3fef638d4dd79a2b6bd6310dd84e61070ca102f42101dfeb06fc26f113fe24017fdbb2589d2f6fbf9af471e99d5a9a7b22399a3fb9dbc80cb1832ca5d0ab4bcf7e3e347ae182338b9f65451a377ef90daff67890ac46fe524418d955097eca77ca8f78340122e6e597dc8dd0818c96e6ddadc01a935939bc38d148b9cf3e44051504bafb803ab9404d9f570397f91a4db8c7",
            "user": {
                "id": 1,
                "region_id": 1,
                "commune_id": 1,
                "dni": "Apciixpab0",
                "name": "Yolanda",
                "last_name": "Nitzsche",
                "address": "4196 Kulas View\nJaylonborough, GA 66636-5201",
                "email": "waylon74@example.com",
                "status": "a",
                "commune": {
                    "id": 1,
                    "name": "Brandiview",
                    "description": "Deleniti corrupti."
                },
                "region": {
                    "id": 1,
                    "name": "Voluptatem veniam nisi corporis aut aut cum vel voluptatem. Voluptatem praesentium blanditiis quia nihil aut sed. Veniam architecto quaerat illo eos sed similique.",
                    "description": "Culpa praesentium et."
                },
                "roles": [
                    {
                        "id": 1,
                        "name": "administrator",
                        "pivot": {
                            "model_id": 1,
                            "role_id": 1,
                            "model_type": "App\\Models\\User"
                        }
                    }
                ]
            }
        },
        "code": 200
    }
}
```
# Users
Request that returns records from the users table.
Optional parameters:

- This route requires authentication:
  In Headers -  Authorization: Bearer {access_token}

- per_page: Sets a limit on the response (integer).
- page: Sets what the current page is (integer).
- status: a or i
- role: administrator or customers
```
GET /users?status={status}&role={role}&per_page={per_page}&page={page}
```


# All endpoints
php artisan route:cache

- In the web browser go to 
```
http://{localhost o domain test}/request-docs
```


# Test
To run the tests, execute the following command:
```
php artisan test
```

# Demo

<hr>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
