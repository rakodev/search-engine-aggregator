Search Engine Aggregator
=========================

Search Engine Aggregator (Only first page) and remove duplicate domain

Command
--------
### Run Unit Tests
* vendor/bin/phpunit

To use this library, simply
--------

* composer init
* composer require rakodev/search-engine-aggregator

Then create an index.php file that will load the autoloader

* require 'vendor/autoload.php';

Usage
-------
```php
$requester = new Requester();
$search = new Search($requester);
$search->setQueryString('PHP');
$result = $search->getContent();
```
