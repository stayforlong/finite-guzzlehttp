# Finite Guzzle HTTP

HTTP Client which grants finite timeouts for requests to 
avoid indefinite waits ([Guzzle](http://docs.guzzlephp.org/en/stable/overview.html) does).

## Installation

Install the latest version through [Composer](https://getcomposer.org/):

```bash
$ composer require stayforlong/finite-guzzlehttp:0.1.0
```

## Usage

Use dependency injection to autoload Guzzle, which is used under the hood:

```php
<?php

use StayForLong\FiniteGuzzleHTTP\Client;

class MyClient {
    private $finiteClient;

    public function __construct(Client $client) {
        $this->finiteClient = $client;
    }

    public function finiteGet($unstableEndpoint) {
        $this->finiteClient->get($unstableEndpoint);
    }
}

// ...

try {
    $myClient->finiteGet(UNSTABLE_ENDPOINT);
} catch (ConnectException $e) {
    // do not let your requests wait forever
}
```
