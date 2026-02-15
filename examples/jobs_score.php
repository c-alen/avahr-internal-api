<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$apiKey = getenv("INTERNAL_API_KEY") ?: null;
$client = new Client("http://127.0.0.1:5000", $apiKey);

$input = [
    'title' => 'Backend Engineer',
    'skills' => ['Python', 'SQL'],
];
$criteria = [
    'Experience' => '0-2=low, 3-5=mid, 6+=high',
    'Skills' => 'match % of required skills',
];
$responseSample = [
    'Experience' => [5, 'mid'],
    'Skills' => [8, 'high'],
];

$result = $client->jobsScore($input, $criteria, $responseSample);
var_dump($result);
