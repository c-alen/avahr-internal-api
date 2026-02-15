<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$client = new Client('http://127.0.0.1:5000');

$plains = [
    "Resume 1 text...",
    "Resume 2 text..."
];
$result = $client->resumeParseBatch($plains);
var_dump($result);
