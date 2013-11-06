academicbrother2
================

1) Installation
---------------

1. Clone the repository:

        git clone https://github.com/aursulis/academicbrother2.git

2. Install Composer:

        cd academicbrother2
        curl -sS https://getcomposer.org/installer | php

3. Fetch required vendor dependencies and configure Symfony:

        php composer.phar install

4. Check your PHP configuration with:

        php app/check.php

5. To get rid of all warnings, on Debian Wheezy, I:

    5.1. upgraded to PHP 5.5 via <http://dotdeb.org>
    
    5.2. installed `php5-mysql`, `php5-intl`
    
    5.3. set the `date.timezone` setting in `/etc/php5/{apache2,cli}/php.ini`, in my case to `Europe/Vilnius`


2) Try it out!
--------------

To launch a development server, do:

    php app/console server:run

The server will be accessible through <http://localhost:8000/app_dev.php>.
