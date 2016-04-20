<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Bhutanio\Movietvdb\MovieScrapper('99a3c168bfb6cd05bd6954d9df271bfa');
dump($client->type('movie')->withImdb('tt0361748')->withTmdb('16869')->scrape());
