<?php

namespace Bhutanio\Movietvdb\Clients;

use Bhutanio\Movietvdb\Contracts\MovieTvInterface;
use Bhutanio\Movietvdb\Data\Episode;
use Bhutanio\Movietvdb\Data\Tv;
use Moinax\TvDb\Client as MoinaxTvDbClient;

class TvdbClient extends Client implements MovieTvInterface
{

    protected $apiUrl = 'thetvdb.com';
    protected $apiSecure = false;

    /**
     * @var MoinaxTvDbClient
     */
    private $tvdb_api;

    private $imagePath = 'http://thetvdb.com/banners/';

    public function __construct($apiKey)
    {
        parent::__construct($this->apiUrl, $apiKey);
        $this->tvdb_api = new MoinaxTvDbClient($this->apiUrl, $this->apiKey);
    }

    public function find($keys, $type = 'tv')
    {
        $key = 'tvdb' . $keys['imdb'];
        $result = $this->cache($key);
        if (!$result) {
            $result = $this->tvdb_api->getSerieByRemoteId(['imdbid' => $keys['imdb']]);
            $this->cache($key, $result);
        }

        if (!empty($result->id)) {
            return $this->tv($result->id);
        }

        return new Tv();
    }

    public function movie($id)
    {
        //
    }

    public function tv($id)
    {
        $key = 'tvdb' . $id;
        $result = $this->cache($key);
        if (!$result) {
            $result = $this->tvdb_api->getSerieEpisodes($id);
            $this->cache($key, $result);
        }

        return $this->formatTv($result);
    }

    public function person($id)
    {

    }

    private function formatTv($data)
    {
        $tv = $data['serie'];

        return new Tv([
            'imdb'        => $tv->imdbId,
            'tvdb'        => $tv->id,
            'title'       => $tv->name,
            'releaseDate' => $tv->firstAired,
            'plot'        => $tv->overview,
            'genres'      => $tv->genres,
            'network'     => $tv->network,
            'runtime'     => $tv->runtime,
            'tvdbRating'  => $tv->rating,
            'tvdbVotes'   => $tv->ratingCount,
            'poster'      => !empty($tv->poster) ? $this->imagePath . $tv->poster : null,
            'episodes'    => $this->formatEpisodes($data['episodes'])
        ]);
    }

    private function formatEpisodes($episodes)
    {
        $tv_episodes = [];
        if (!empty($episodes)) {
            foreach ($episodes as $episode) {
                $tv_episodes[] = new Episode([
                    'episode'     => $episode->number,
                    'season'      => $episode->season,
                    'title'       => $episode->name,
                    'releaseDate' => $episode->firstAired,
                    'plot'        => $episode->overview,
                    'photo'       => !empty($episode->thumbnail) ? $this->imagePath . $episode->thumbnail : null,
                ]);
            }
        }

        return $tv_episodes;
    }
}