# WebTech-FabLab-N2
Symfony website for event business - School project

# Installation
You should have already install all default dependencies (PHP, MySQL, Composer, Symfony-CLI,.. +Apache for production purpose)
Then you can follow those steps :
- Clone project
- Create your version of .env (as ".env.local") where you should define your database and mailer parameters (set "APP_ENV = prod" if using in prod)
- Set "DATABASE_URL" using template with your credentials
- Set "MAILER_DNS" using your mailer service credentials
- Run "composer install"
- Structure your database with "php bin/console doctrine:migrations:migrate"
- Run "yarn install"

# Running project in local
To run the project you should :
- Run "yarn watch"
- Run "symfony serve"
