
** How to run code
```console
git clone git@github.com:mnk1985/isoft.git isb-task
composer install
php artisan key:generate
cp .env.example .env
```
make sure to edit db settings in .env
```console
php artisan migrate

```

** Notes on implementation
Implemented with laravel 5.6, tymon/jwt-auth, bosnadev/repositories

Crontab command to generate summary (from previous day transactions):
```console
47 23 */2 * * php PATH_TO_LARAVEL_ROOT/artisan command:calculate-summary
```
(result will be placed in storage/app/sum.txt)
(laravel command is located in App\Console\Commands)


** What has not been done
- amount in float (it mat be not the best option for calculation)
- time in server's local time (don't take into account timezone)
- some specific Transaction repository queries are created with Eloquent, but not with Repository Criterias 
- no unit tests