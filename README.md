# Hippomundo Coding Test

Hi! Welcome to the Hippomundo Coding Test project, which is used to evaluate 
code quality and efficiency in engineering candidates for the Hippomundo team.

## Requirements
- Docker (https://docs.docker.com/install/)

## Installation of the test project
```
cp .env.example .env
docker compose build
docker compose run web composer install
docker compose run web npm install
docker compose run web php artisan key:generate
docker compose run web php artisan migrate --seed
docker compose run web npm run dev
```

Then, in another tab or window, run the PHP server:
```
docker compose run web php artisan serve
```

You should now be able to browse to http://localhost:8000 and see the project.
Either you can register a new account in the system, or you can use the following 
credentions to log in:
```
Email: Farmboy2Jedi@TheForce.net
Pass:  password
```

Note: Make sure that the port 8000 is available on your machine. If not, you can 
change it in your .env file, and provide another port to listen on for the 
artisan serve command. For example:

```docker compose run web php artisan serve --port=8001```