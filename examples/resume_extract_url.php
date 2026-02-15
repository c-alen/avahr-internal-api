<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$client = new Client('http://127.0.0.1:5000');

$result = $client->resumeExtractFromUrl('https://example.com/resume.pdf');
var_dump($result);
