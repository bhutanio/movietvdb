<?php

namespace Bhutanio\Movietvdb\Data;

use Carbon\Carbon;

class Movie
{
    public $imdb;

    public $tmdb;

    public $title;

    public $aka = [];

    public $releaseDate;

    public $releaseYear;

    public $plot;

    public $countries = [];

    public $languages = [];

    public $genres = [];

    public $runtime;

    public $poster;

    public $videoTrailer;

    public $wikiUrl;

    public $tmdbRating;

    public $tmdbVotes;

    public $imdbRating;

    public $imdbVotes;

    public function __construct($data)
    {
        $data = $this->initData($data);

        $release_date = $data['releaseDate'] ? new Carbon($data['releaseDate']) : null;

        $this->imdb = $data['imdb'];
        $this->tmdb = $data['tmdb'];
        $this->title = $data['title'];
        $this->aka = $data['aka'];
        $this->releaseDate = $release_date;
        $this->releaseYear = $release_date ? $release_date->year : null;
        $this->plot = $data['plot'];
        $this->countries = $data['countries'];
        $this->languages = $data['languages'];
        $this->genres = $data['genres'] ? (new Genre($data['genres']))->genre : null;
        $this->runtime = $data['runtime'];
        $this->poster = $data['poster'];
        $this->videoTrailer = $data['videoTrailer'];
        $this->wikiUrl = $data['wikiUrl'];
        $this->tmdbRating = $data['tmdbRating'];
        $this->tmdbVotes = $data['tmdbVotes'];
        $this->imdbRating = $data['imdbRating'];
        $this->imdbVotes = $data['imdbVotes'];
    }

    public function merge(Movie $data, Movie $data2, Movie $data3 = null)
    {
        $args = func_get_args();
        $base_movie = $args[0];
        unset($args[0]);

        foreach ($args as $arg) {
            foreach ($arg as $arg_key => $arg_value) {
                if (empty($base_movie->{$arg_key})) {
                    $base_movie->{$arg_key} = $arg_value;
                }
            }
        }

        return $base_movie;
    }

    private function initData($data)
    {
        return $data + [
            'imdb'         => null,
            'tmdb'         => null,
            'title'        => null,
            'aka'          => null,
            'releaseYear'  => null,
            'releaseDate'  => null,
            'plot'         => null,
            'countries'    => null,
            'languages'    => null,
            'genres'       => null,
            'runtime'      => null,
            'poster'       => null,
            'videoTrailer' => null,
            'wikiUrl'      => null,
            'tmdbRating'   => null,
            'tmdbVotes'    => null,
            'imdbRating'   => null,
            'imdbVotes'    => null,
        ];
    }


}
