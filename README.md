# WebTech-FabLab-N2
Symfony website for event business - School project

# Installation
You should have already install all default dependencies (PHP, MySQL, Composer, Symfony-CLI,.. +Apache for production purpose)
Then you can follow those steps :
- Clone project
- Create your version of .env (as ".env.local") where you should define your database and mailer parameters (set "APP_ENV = prod" if using in prod)
- Run "composer install"
- Run "yarn install"

# Running project in local
To run the project you should :
- Run "yarn watch"
- Run "symfony serve"
