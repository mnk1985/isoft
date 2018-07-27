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
php artisan server
```
and now you can reach http://127.0.0.1:8000.
List of routes is available with
```console
php artisan route:list
```

## Project structure
- database/migrations - migrations for users, customers, transactions
- App - eloquent models  (with defined relationships)
- App\Http\Requests - form requests to validate submitted data
- App\Http\DTO - api responses
- App\Policies - authorization for resources
- App\Repositories - repositories (injected in controllers, autowired. Bindings are defined in App\Providers\AppServiceProvider)
- App\Console\Commands - console commands

### Models
- User
- Consumer (1 user has many customers)
- Transaction (1 consumer has many transactions)

### API endpoints
User
- api/auth/login (POST)
- api/auth/logout (POST)
- api/auth/me (POST)
- api/auth/refresh (POST)

Customer
- api/customer (POST) - create customer

Transaction
- api/transaction (POST) - create transaction
- api/transaction/{transactionId} (GET) - get transaction
- api/transaction/{transactionId} (PATCH) - update transaction
- api/transaction/{transactionId} (DELETE) - delete transaction
- api/transactions (POST) - get transactions (with parameters to filter results)
- api/transaction/{customerId}/{transactionId} (GET) - get transactions
api/transactions/{customerId}/{amount?}/{date?}/{offset?}/{limit?} (GET) - get filtered transactions

### GUI endpoints
{HOST} - home page
{HOST}/register - register page
{HOST}/login - login page
{HOST}/transactions - show all transactions which belong to customers, which in its turn belong to logged in user


### Crontab command
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