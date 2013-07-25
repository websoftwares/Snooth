# Snooth

PHP client for interacting with the [api.snooth.com](https://api.snooth.com/ "snooth.com") RESTful api.

[![Build Status](https://api.travis-ci.org/websoftwares/Snooth.png)](https://travis-ci.org/websoftwares/Snooth)

## Documentation
We encourage you to read the [documentation](https://api.snooth.com/ "api.snooth.com") carefully before proceeding.

## Api Key
U need to [register](https://api.snooth.com/register/ "api.snooth.com") to obtain an api key.

## Installing via Composer (recommended)

Install composer in your project:
```
curl -s http://getcomposer.org/installer | php
```

Create a composer.json file in your project root:
```
{
    "require": {
        "websoftwares/snooth": "dev-master"
    }
}
```

Install via composer
```
php composer.phar install
```

## Usage
Below u find a list with available methods.

## GetWineByAvin
Gets a wine by Avin.

```php
use Websoftwares\AvinClient, Websoftwares\Avin;

$avin = new Avin(new AvinClient('123456789YourApiKey'));
$avin->GetWineByAvin('AVIN0123456789012');

```

## Error message
Use try/catch block to get error message.

```php
use Websoftwares\AvinClient,
	Websoftwares\Avin,
	Websoftwares\AvinException;

try {
	$avin = new Avin(new AvinClient('123456789YourApiKey'));
	$avin->GetWinesByName('Era');
} catch (AvinException $e) {
	echo $e->getMessage();
}

```

## Testing
In the tests folder u can find several tests for online and offline.