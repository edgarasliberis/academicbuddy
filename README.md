academicbrother2
================

1) Installation
---------------

1. Clone the repository:

        $ git clone https://github.com/aursulis/academicbrother2.git

2. Install Composer:

        $ cd academicbrother2
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

6. To get rid of all warnings, on Debian Wheezy, I:

    5.1. upgraded to PHP 5.5 via <http://dotdeb.org>
    
    5.2. installed `php5-mysql`, `php5-intl`
    
    5.3. set the `date.timezone` setting in `/etc/php5/{apache2,cli}/php.ini`, in my case to `Europe/Vilnius`

2) Try it out!
--------------

To launch a development server, do:

    $ php app/console server:run

The server will be accessible through <http://localhost:8000/app_dev.php>.

3) Configure Bootstrap frontend framework
--------------

1. Update dependecies

        $ php composer.phar update
        
3. Add the following to `app/config/config.yml`

        # Assetic Configuration
        assetic:
            debug:          %kernel.debug%
            use_controller: false
            bundles:        [ ]
            #java: /usr/bin/java
            filters:
                cssrewrite: ~
                #closure:
                #    jar: %kernel.root_dir%/Resources/java/compiler.jar
                #yui_css:
                #    jar: %kernel.root_dir%/Resources/java/yuicompressor-2.4.7.jar
            filters:
                less:
                    node: /usr/bin/node
                    node_paths: [/usr/local/lib/node_modules]
                    apply_to: "\.less$"
                cssrewrite: ~
            assets:
                bootstrap_css:
                    inputs:
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/less/bootstrap.less
                    filters:
                        - less
                        - cssrewrite
                    output: css/bootstrap.css
                bootstrap_js:
                    inputs:
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/transition.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/alert.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/button.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/carousel.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/collapse.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/dropdown.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/modal.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/tooltip.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/popover.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/scrollspy.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/tab.js
                        - %kernel.root_dir%/../vendor/twbs/bootstrap/js/affix.js
                        - %kernel.root_dir%/../vendor/braincrafted/bootstrap-bundle/Braincrafted/Bundle/BootstrapBundle/Resources/js/bc-bootstrap-collection.js
                    output: js/bootstrap.js
                jquery:
                    inputs:
                        - %kernel.root_dir%/../vendor/jquery/jquery/jquery-1.10.2.js
                    output: js/jquery.js
        #Bootstrap configuration            
        braincrafted_bootstrap:
            output_dir: %kernel.root_dir%/../web
            assets_dir: %kernel.root_dir%/../vendor/twbs/bootstrap
            jquery_path: %kernel.root_dir%/../vendor/jquery/jquery/jquery-1.10.2.js
            less_filter: less # "less", "lessphp" or "none"
            auto_configure:
                assetic: true
                twig: true
                knp_menu: true
                knp_paginator: true
            customize_variables:
                variables_file: ~
                bootstrap_output: %kernel.root_dir%/Resources/less/bootstrap.less
                bootstrap_template: BraincraftedBootstrapBundle:Bootstrap:bootstrap.less.twig
4. Run `php app/console assetic:dump` to generate assests in `/web` folder (make them accessible to templates).
