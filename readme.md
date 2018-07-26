

implemented with laravel 5.6, tymon/jwt-auth

crontab command to generate summary (from previous day transactions):
47 23 */2 * * php PATH_TO_LARAVEL_ROOT/artisan command:calculate-summary
(result will be placed in storage/app/sum.txt)


** :
- amount in float (it mat be not the best option for calculation)
- time in server's local time
- no unit tests