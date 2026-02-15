<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Avahr\InternalApi\Client;

$client = new Client('http://127.0.0.1:5000');

$resumePlain = "John Doe\nPython, Flask, SQL\n5 years experience...";
$jobDescription = "We need a Python backend engineer with Flask and SQL...";

$result = $client->candidatesScore($resumePlain, $jobDescription);
var_dump($result);
