academicbuddy
================

0) Prerequisites
----------------

    >= PHP 5.3.9
    MySQL (mysql-client, mysql-server)
    php5-mysql
    php5-intl
    nodejs (with symlink to /usr/bin/node)
    LESS (installed through npm)

1) Installation
---------------

1. Clone the repository:

        $ git clone https://github.com/edgarasliberis/academicbuddy.git

2. Install Composer:

        $ cd academicbuddy
        $ curl -sS https://getcomposer.org/installer | php

3. Create a database and user to use with Symfony:

        $ mysql -u root -p
        Enter password:
        
        mysql> create database academicbrother2;
        mysql> create user 'symfony'@'localhost' identified by 'notsosecret';
        mysql> grant all privileges on academicbrother2.* to 'symfony'@'localhost';

4. Fetch required vendor dependencies and configure Symfony:

        $ php composer.phar install

5. Check your PHP configuration with:

        $ php app/check.php
    
   To get rid of the timezone warning, set the `date.timezone` setting in `/etc/php5/{apache2,cli}/php.ini`, in my case to `Europe/London`

2) Try it out!
--------------

To launch a development server, do:

    $ php app/console server:run

The server will be accessible through <http://localhost:8000/app_dev.php>.

3) Generate database tables
--------------

1. Create db

        $ php app/console doctrine:database:create

2. Generate tables

        $ php app/console doctrine:schema:update --force

3. Populate tables with default data

        $ php app/console ab:dbpopulate db_resources/UK_uni_list.txt

4. Create an administrator user

        $ php app/console ab:createadmin

4) Configure Bootstrap frontend framework
--------------

1. Run `php app/console assetic:dump` to generate assests in `/web` folder (make them accessible to templates).
