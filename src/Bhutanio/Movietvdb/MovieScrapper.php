<?php

namespace Bhutanio\Movietvdb;

use Bhutanio\Movietvdb\Clients\OmdbClient;
use Bhutanio\Movietvdb\Clients\TmdbClient;
use Bhutanio\Movietvdb\Data\Movie;

class MovieScrapper
{
    public $type;

    protected $imdb;
    protected $tmdb;
    protected $tvdb;

    private $tmdbClient;
    private $omdbClient;

    public function __construct($tmdb_key = null, $tvdb_key = null, $omdb_key = null)
    {
        $this->tmdbClient = new TmdbClient($tmdb_key);
        $this->omdbClient = new OmdbClient($omdb_key);
    }

    /**
     * @param string $type movie,tv,anime
     *
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function scrape()
    {
        $movie = new Movie([]);
        $tmdb_movie = new Movie([]);
        $omdb_movie = new Movie([]);

        if ($this->type == 'movie') {
            if ($this->imdb && !$this->tmdb) {
                $tmdb_results = $this->tmdbClient->find($this->imdb);
                if (isset($tmdb_results['movie_results'][0]['id'])) {
                    $tmdb_movie = $this->tmdbClient->movie($tmdb_results['movie_results'][0]['id']);
                    $this->tmdb = empty($this->tmdb) ? $tmdb_movie->tmdb : $this->tmdb;
                }
                $omdb_movie = $this->omdbClient->movie($this->imdb);
            }

            if ($this->tmdb && !$this->imdb) {
                $tmdb_movie = $this->tmdbClient->movie($this->tmdb);
                $this->imdb = empty($this->imdb) ? $tmdb_movie->imdb : $this->imdb;
            }

            if ($this->tmdb && $this->imdb) {
                $tmdb_movie = $this->tmdbClient->movie($this->tmdb);
                $omdb_movie = $this->omdbClient->movie($this->imdb);
            }
        }

        return $movie->merge($tmdb_movie, $omdb_movie);
    }

    public function withImdb($id)
    {
        $this->imdb = $id;

        return $this;
    }

    public function withTmdb($id)
    {
        $this->tmdb = $id;

        return $this;
    }

    public function withTvdb($id)
    {
        $this->tvdb = $id;

        return $this;
    }
}
