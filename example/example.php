<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Bhutanio\Movietvdb\MangaUpdatesClient();
$manga = $client->manga('15');

dump($manga);
