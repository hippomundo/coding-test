# Hippomundo Coding Test

Hi! Welcome to the Hippomundo Coding Test project, which is used to evaluate 
code quality and efficiency in engineering candidates for the Hippomundo team.




## Installation of the test project
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```

Make sure that the port 8000 is available on your machine. If not, you can change it in the .env file, and provide another port to listen on for the artisan serve command.