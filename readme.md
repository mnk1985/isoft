## Notes on implementation
Implemented with laravel 5.6, tymon/jwt-auth, bosnadev/repositories


## How to run code
```console
git clone git@github.com:mnk1985/isoft.git isb-task
cd isb-task
composer install
php artisan key:generate
php artisan jwt:secret
cp .env.example .env
```
make sure to edit db settings in .env, and then run
```console
php artisan migrate
```

## Project structure
- database/migrations - migrations for users, customers, transactions
- App - eloquent models  (with defined relationships)
- App\Http\Requests - form requests to validate submitted data
- App\Http\DTO - api responses
- App\Policies - authorization for resources
- App\Repositories - repositories (injected in controllers, autowired. Bindings are defined in App\Providers\AppServiceProvider)
- App\Console\Commands - console commands

## Crontab command
Crontab command to generate summary (from previous day transactions):
```console
47 23 */2 * * php PATH_TO_LARAVEL_ROOT/artisan command:calculate-summary
```
(result will be placed in storage/app/sum.txt)
(laravel command is located in App\Console\Commands)


## What has not been done:
- amount in float (it mat be not the best option for calculation's accuracy)
- time in server's local time (so, user timezone is not taken into account)
- some specific Transaction repository queries are created with Eloquent, but not with Repository Criterias 
- no unit tests