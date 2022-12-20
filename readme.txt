How to add laravel passport for api authentication
1. composer require laravel/passport
2. Laravel\Passport\PassportServiceProvider::class paste this line in the app.php inside config folder
    within the providers array.
3. php artisan migrate : no migrate the passports tables.
4. php artisan passport:install , this will generate two clients with id and secret key.
5. In the AuthServiceProvider.php inside the providers file uncomment the line with policies array and add Passport::routes();
    within the boot function.
6. Inside the auth.php in the config folder add a new guard call api and add driver as passport
    and providers as users.
7. composer require laravel/ui
8. php artisan ui vue --auth

