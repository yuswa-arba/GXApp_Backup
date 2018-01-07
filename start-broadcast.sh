
laravel-echo-server start; redis-server; php artisan queue:work -queue=checker,default,attendance &