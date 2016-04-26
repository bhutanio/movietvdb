<?php

namespace Bhutanio\Movietvdb\Data;

use Carbon\Carbon;

class Movie
{
    /**
     * @var string
     */
    public $imdb;

    /**
     * @var int
     */
    public $tmdb;

    /**
     * @var string
     */
    public $title;

    /**
     * @var array
     */
    public $aka;

    /**
     * @var Carbon
     */
    public $releaseDate;

    /**
     * @var int
     */
    public $releaseYear;

    /**
     * @var string
     */
    public $plot;

    /**
     * @var array
     */
    public $countries;

    /**
     * @var string
     */
    public $language;

    /**
     * @var array
     */
    public $languages;

    /**
     * @var array
     */
    public $genres;

    /**
     * @var int
     */
    public $runtime;

    /**
     * @var array
     */
    public $actors;

    /**
     * @var array
     */
    public $directors;

    /**
     * @var array
     */
    public $writers;

    /**
     * @var array
     */
    public $producers;

    /**
     * @var string
     */
    public $poster;

    /**
     * @var array
     */
    public $posters;

    /**
     * @var string
     */
    public $backdrop;

    /**
     * @var array
     */
    public $backdrops;

    /**
     * @var string
     */
    public $videoTrailer;

    /**
     * @var string
     */
    public $wikiUrl;

    /**
     * @var string
     */
    public $rated;

    /**
     * @var float
     */
    public $tmdbRating;

    /**
     * @var int
     */
    public $tmdbVotes;

    /**
     * @var float
     */
    public $imdbRating;

    /**
     * @var int
     */
    public $imdbVotes;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                if (is_array($value) && !count($value)) {
                    $value = null;
                }
                $this->$key = $value;
            }
        }

        if ($this->releaseDate instanceof \DateTime) {
            $release_date = $this->releaseDate ? (new Carbon())->instance($this->releaseDate) : null;
        } else {
            $release_date = $this->releaseDate ? new Carbon($this->releaseDate) : null;
        }
        $this->releaseDate = $release_date;
        $this->releaseYear = $release_date ? $release_date->year : null;

        $this->title = $this->cleanTitle($this->title);
    }

    public function merge(Movie $data, Movie $data2 = null)
    {
        $movies = func_get_args();

        foreach ($movies as $movie) {
            foreach ($movie as $movie_key => $movie_value) {
                if (empty($this->$movie_key)) {
                    $this->$movie_key = $movie_value;
                }
            }
        }

        return $this;
    }

    private function cleanTitle($title)
    {
        if (strlen($title) > 4) {
            $might_be_year_one = str_replace(substr($title, 0, -6), '', $title);
            $might_be_year = str_replace(['(', ')'], '', $might_be_year_one);
            if ($might_be_year > 1900 && $might_be_year < (date('Y') + 100)) {
                $title = trim(str_replace($might_be_year_one, '', $title));
            }
        }

        return $title;
    }
}
