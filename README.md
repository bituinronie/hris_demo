# HRMIS
<a href="https://https://www.php.net/releases/8.0/en.php"><img alt="PHP Versions Supported" src="https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg"></a>


## Starting Up
To start this laravel api, first make a copy of `.env` using the file `env.example` then after than, configure your mysql emvironment, this is only for example: 
```env
    DB_CONNECTION=mysql
    DB_HOST=<database host>
    DB_PORT=<database port>
    DB_DATABASE=<database name>
    DB_USERNAME=<database username>
    DB_PASSWORD=<database password>
```
**NOTE:** 
- if your using Docker enviroment `DB_HOST` must be the same with `docker_compose.yml` mysql name.
- set-up the smtp using [mailtrap.io](https://mailtrap.io). Also add to `.env` file this lines:

```env
    MAIL_FROM_ADDRESS=<email address>
    MAIL_FROM_NAME="${APP_NAME}"
```

- add/edit your env variable for `APP_URL`. see example below: 
```env
    APP_URL=http://localhost:8088
```

After setting the `.env` run the following commands:
1. `composer install`
2. `composer dump-autoload`
3. `php artisan key:generate`
4. `php artisan config:clear`
5. `php artisan jwt:secret`
6. `php artisan migrate`
7. `php artisan db:seed`
8. `php artisan storage:link`

## My Pre-Applied Functions
Apply settings/functionalities to what you want to do is verry effective, that's why I make this API adjustable. Check this out:
1. `APP_TIMEZONE` - This Environment Setting(`.env`) can change your app timezone. The default value is `Asia/Manila`
2. `Context` - This will help you ease the repetative coding of CRUD and others. [check this out!](/CONTEXT.md)

## Packages I Use
I use different packages on this laravel app for better and easy functionalities application. To read their Documentation, Here links:
1. **Laravel JWT Authetication** - [click here](https://jwt-auth.readthedocs.io/en/develop/)
2. **Laravel Roles & Permission** - [click here](https://spatie.be/docs/laravel-permission/v3/introduction)
3. **DOMPDF Wrapper for Laravel** - [click here](https://github.com/barryvdh/laravel-dompdf)
4. **Laravel Media Library** - [click here](https://spatie.be/docs/laravel-medialibrary/v9/introduction)

## Understanding the Repository
### Branches
- `prod` - The default branch, were everthing is ready to deploy.
- `main` - This branch is for testing and staging website.
- `dev` - This branch will have the latest changes.
### Commits
To spice up my commits I added emojis at the start of my message to easily determine what type of commit I done.
- ☕️ (coffee) for initial / not important changes
- 💯 (100) functions / routes / migration / etc...
- 🐛 (bug) error fixes
- ⚙️ (gear) todo stuffs
- 📓 (notebook) ReadMe / comments / instructions / documentation
 
 To use emoji on your message just put **:** at the beginning and end of the emoji word. Example: `:coffee:` to :coffee:

## Docker Set-Up
Check this repo to get my Docker Environment: [link to docker laravel environment (php8.0_npm branch)!](https://github.com/JeremieVinzeC/docker-laravel-rest-api/tree/php8.0_npm)

After pulling the repo to run the docker env: `docker-compose up -d --build` then **clone this repo to the src folder** for composer and artisan usage:!
   
- **Composer**  `docker-compose run --rm composer <command>`
- **Artisan** `docker-compose run --rm artisan <command>`
- **npm** `docker-compose run --rm npm <command>`

:information_source: On this case `composer install` on docker will result an error, so to fix that you must use this command: `composer install --ignore-platform-reqs`

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
