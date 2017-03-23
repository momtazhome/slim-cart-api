# Cart APIs based on SLIM 

Design

1. Cart is specific to a user. So any cart can be uniqely identified by the user id.

There are five apis:

1. Adding an item to the cart
2. Removing an item from the cart
3. Updating the count of an item in the cart.
4. Getting all the items from the cart.
5. Getting the user information.

The list of apis and their controllers can be found from the file : src/routes.php

## Install the Application

1. Run composer install 
2. Point the web server root to the public directory of this repository.
3. Migrate the database - create a database, say "cart" with a user having the right priveleges and update the same in src/settings.php
4. Run the phinx db migration and seeder using commands - >> vendor/bin/phinx migrate -e development ; vendor/bin/phinx migrate seed:run
