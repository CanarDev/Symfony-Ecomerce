# DROELOE PROJECT
### Sell droeloe pictures album

#### Install symfony :
    curl -sS https://get.symfony.com/cli/installer | bash

### command at the root of the project:
    composer install

## now create your .env.local file !
You need to copy & paste .env, rename this file .env.local and set up your database connection.

#

## Second Step

### Install webpack-encore-bundle :
    composer require symfony/webpack-encore-bundle

### Now Install npm in the project !
    npm install

### Create the database :
    php bin/console dotrine:create:database

### after that, do:
    php bin/console dotrine:migration:m

### And load fixtures :
     php bin/console doctrine:fixtures:load -n

### Start the project with this command:
    symfony server:start
#
### Enjoy !