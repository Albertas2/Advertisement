# Advertisement website

A small web application that displays advertisements posted by users.

**Requirements**
* Apache WebServer
* PHP >=5.6.21
* MySql DB

**Installation**
1. With GIT checkout source code
2. Install Composer
3. Run command ```composer install```
4. Set-up database in app/config/parameters.yml
5. Run command ``` php bin/console doctrine:database:create```
6. Run command ``` php bin/console doctrine:schema:update --force```