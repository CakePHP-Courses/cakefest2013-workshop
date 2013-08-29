Get Started
-----------

* Download a copy
* Install composer

````
    curl -sS https://getcomposer.org/installer | php
````
* Run composer

````
    php composer.phar install
````

* Create core.php

````
    cp ./Vendor/pear-pear.cakephp.org/CakePHP/Cake/Console/Templates/skel/Config/core.php ./Config/core.php
````
* Create Database in mysql

````
    echo "CREATE DATABASE bakers" | mysql -uroot -p -hlocalhost
````

* Create database.php

````
    Console/cake
````
there is a wizard to make database.php for you

* Run Migration

````
    Console/cake Migrations.migration run all
````

Install ElasticSearch (ubuntu 12.10)
------------------------------------

    sudo apt-get install openjdk-7-jre-headless
    cd /tmp/
    wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-0.90.3.deb
    sudo dpkg -i elasticsearch-0.90.3.deb

Elasticsearch is now running with a default cluster name of "elasticsearch" on port 9200 with default settings.
