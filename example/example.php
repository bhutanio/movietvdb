<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Bhutanio\Movietvdb\TmdbClient('99a3c168bfb6cd05bd6954d9df271bfa');

$movie = $client->movie('293660');
$mgenre = [];
foreach($movie['genres'] as $genre) {
    $mgenre[] = $genre['name'];
}

$mgenre[] = 'Bla Bla';

$genres = new \Bhutanio\Movietvdb\Data\Genre($mgenre);
dump($genres);

//dump();
//dump($client->credits('293660'));
