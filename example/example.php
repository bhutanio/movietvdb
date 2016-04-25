<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \Bhutanio\Movietvdb\MovieScrapper('', '');

$movie = $client->scrape('movie', 'tt0133093');
dump($movie);

$movie = $client->scrape('tv', 'tt3444938');
dump($movie);