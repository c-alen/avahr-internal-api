<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$apiKey = getenv("INTERNAL_API_KEY") ?: null;
$client = new Client("http://127.0.0.1:5000", $apiKey);

$plain = "John Doe\njohn@example.com\n(555) 123-4567\n...";
$result = $client->resumeParse($plain);
var_dump($result);
