StarRentals
===========

## Prerequisites

* PHP >= 5.6
* MySQL 5

## Install

* `composer install`
* `app/console doctrine:database:create`
* `app/console doctrine:schema:update --force`
* `app/console assets:install --symlink`
* Goto your local webserver and enjoy!

## Implemented

*Took me 5 hours*

* List/Create/Modify Vehicles (color check implemented)
* List/Create/Modify Clients
* List/Create/Modify Bookings (sorted)
* Vehicle upgrade checking using Ajax (also checked during form submission)

## TODO

* Using Symfony 2.6 but still implementing in 2.3 style
* Implement vehicle booking interval checking (currently you can assign a vehicle twice in a given time interval)
* Fixtures
* Testing core components
* Proper page structure (menu / footer / nav) + design
* Optimize code and rewrite some queries to perform eager joins (lazy loading ftw)
