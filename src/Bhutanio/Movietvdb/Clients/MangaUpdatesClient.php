<?php

namespace Bhutanio\Movietvdb\Clients;

use Bhutanio\Movietvdb\Contracts\MangaInterface;
use Symfony\Component\DomCrawler\Crawler;

class MangaUpdatesClient extends Client implements MangaInterface
{
    protected $apiUrl = 'www.mangaupdates.com/';
    protected $apiSecure = true;

    protected $apiSeriesUrl = 'series.html?id=';
    protected $apiAuthorUrl = 'authors.html?id=';

    public function __construct()
    {
        parent::__construct($this->apiUrl);
    }

    public function find($key)
    {

    }

    public function manga($id)
    {
        $webpage = $this->request($this->apiUrl . $this->apiSeriesUrl . $id);
        $dom = new Crawler($webpage);

        $data = [];
        $data['description'] = $dom->filter('.sContainer .sContent')->first()->html();

        preg_match('/(?:class\=\"sCat\"\>\<b\>Associated Names\<\/b\>\<\/div\>)+\n?(?:\<div class\=\"sContent\" \>)(.+)(?:\n?+\<\/div\>)/i',
            $webpage, $aka_titles);
        $aka_titles = explode('<br />', $aka_titles[1]);
        $data['aka_titles'] = array_filter($aka_titles, 'html_entity_decode');

        preg_match('/(?:class\=\"sCat\"\>\<b\>Genre\<\/b\>\<\/div\>)+\n?(?:\<div class\=\"sContent\" \>)(.+)(?:\n?+\<\/div\>)/i',
            $webpage,
            $genre_block);
        preg_match_all('/series\.html\?act\=genresearch\&amp\;genre\=([\w-+]+)/i', $genre_block[1], $genres);
        $data['genres'] = array_filter($genres[1], 'urldecode');

        return $data;
    }

    public function authors($id)
    {

    }

    public function characters($id)
    {

    }
}