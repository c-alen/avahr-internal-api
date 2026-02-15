<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$apiKey = getenv("INTERNAL_API_KEY") ?: null;
$client = new Client("http://127.0.0.1:5000", $apiKey);

// Example: parse resume text
$parsed = $client->resumeParse("John Doe\njohn@example.com\n(555) 123-4567\n...");
var_dump($parsed);

// Example: job generate
$job = $client->jobGenerate('Write a Senior Backend Engineer job description for a fintech company.');
var_dump($job);
