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

## Example Usage
Please read the [documentation](https://api.snooth.com/ "api.snooth.com") for a complete list of available methods and paramaters.


```php
use Websoftwares\SnoothClient,
	Websoftwares\Snooth,
	Websoftwares\SnoothException;

try {
	$snooth = new Snooth(new SnoothClient('123456789YourApiKey'));

	// Set parameters for method and get response for this method on the snooth api
	$response = $snooth->setParameter('a', 0)->api('wines');

} catch (SnoothException $e) {
	echo $e->getMessage();
}

```

## Testing
In the tests folder u can find several tests for online and offline.