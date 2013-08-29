# cakefest2013-workshop

## Basic Setup

Download the github repo:

	git checkout https://github.com/CakePHP-Courses/cakefest2013-workshop.git

Use composer to get the dependencies:

	composer install

Move a fresh core.php from the cake core into your APP/Config/ folder.
Don't forget to modify the salt and cipherSeed values.

Create a database.php and test your config via

	http://localhost:8080

All should be green.

Connect to the Migrations shell to import the database tables:

	cake Migrations.Migrate run

Select the current one and confirm. Result: "All migrations have completed."
Also, all the tables should be created in your database.

All good to go.