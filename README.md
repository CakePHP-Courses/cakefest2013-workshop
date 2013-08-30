# cakefest2013-workshop

## Basic Setup

Download the github repo:

	git checkout https://github.com/CakePHP-Courses/cakefest2013-workshop.git

Use composer to get the dependencies:

	composer install

Move a fresh core.php from the cake core into your APP/Config/ folder.

    cp ./Vendor/pear-pear.cakephp.org/CakePHP/Cake/Console/Templates/skel/Config/core.php ./Config/core.php

Don't forget to modify the salt and cipherSeed values.

Create a database.php (Console/cake will have a wizard) and test your config via

	http://localhost:8080

All should be green.

Connect to the Migration shell to import the database tables:

	Console/cake Migrations.Migration run all

Select the current one and confirm. Result: "All migrations have completed."
The database and all the tables should be created.

All good to go.

## Install ElasticSearch (ubuntu 12.10)

    sudo apt-get install openjdk-7-jre-headless
    cd /tmp/
    wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-0.90.3.deb
    sudo dpkg -i elasticsearch-0.90.3.deb

Elasticsearch is now running with a default cluster name of "elasticsearch" on port 9200 with default settings.

## Create ElasticSearch index and mapping

    Console/cake Elastic.elastic create_index bakers
    Console/cake Elastic.elastic mapping User
