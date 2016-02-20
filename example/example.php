<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Bhutanio\Movietvdb\TmdbClient('99a3c168bfb6cd05bd6954d9df271bfa');

dump($client->find('tt0120737'));
