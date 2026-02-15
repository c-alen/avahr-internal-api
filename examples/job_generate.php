<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$client = new Client('http://127.0.0.1:5000');

$result = $client->jobGenerate('Write a Senior Backend Engineer job description for a fintech company.');
var_dump($result);
