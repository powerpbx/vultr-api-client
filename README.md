PHP API Client for api.vultr.com
================================

**Consider this to be a beta release that will become final in the next few
days! Not all calls have been properly tested!**

## Install using composer

Open a shell, `cd` to your poject and type:

```sh
composer require malc0mn/vultr-api-client dev-master
```

or edit composer.json and add:

```json
{
    "require": {
        "malc0mn/vultr-api-client": "dev-master"
    }
}
```

If you want to use the `GuzzleHttpAdapter`, you will need to add [Guzzle 5](https://github.com/guzzle/guzzle/tree/5.3)
or [Guzzle 6](https://github.com/guzzle/guzzle).

## Usage examples

###### Guzzle

```php
require 'vendor/autoload.php';

Use Vultr\VultrClient;
Use Vultr\Adapter\GuzzleHttpAdapter;

// Using Guzzle 5 or 6...
$client = new VultrClient(
    new GuzzleHttpAdapter('your-api-key')
);

$result = $client->metaData()->getAccountInfo();

var_export($result);
```

###### CURL

```php
require 'vendor/autoload.php';

Use Vultr\VultrClient;
Use Vultr\Adapter\CurlAdapter;

// Using regular CURL, courtesy of 'usefulz'
$client = new VultrClient(
    new CurlAdapter('your-api-key')
);

$result = $client->metaData()->getAccountInfo();

var_export($result);
```

## Vultr API documentation

The full API documentation can be found on https://www.vultr.com/api and has
been partly added to the PHP DocBlocks companioning the PHP functions that
implement the actual calls.

## Credits

The original version of this API is done by [usefulz](https://github.com/usefulz/vultr-api-client).
This version has been forked by [integr.io](http://integr.io/) for use in one of
our Symfony applications.
It has been reworked with extensability and ease of use in mind.
