<?php

namespace Bhutanio\Movietvdb\Clients;

use Bhutanio\Movietvdb\Contracts\MovieTvInterface;
use Bhutanio\Movietvdb\Data\Movie;

class TmdbClient extends Client implements MovieTvInterface
{
    protected $apiUrl = 'api.themoviedb.org/3/';
    protected $apiSecure = true;

    private $imagePath = 'https://image.tmdb.org/t/p/w780';
    private $imageOriginalPath = 'https://image.tmdb.org/t/p/original';

    public function __construct($apiKey)
    {
        parent::__construct($this->apiUrl, $apiKey);
    }

    public function find($key)
    {
        $this->validateImdbId($key);
        $url = $this->apiUrl . 'find/' . $key . '?api_key=' . $this->apiKey . '&external_source=imdb_id';

        return $this->toArray($this->request($url));
    }

    public function movie($id)
    {
        $url = $this->apiUrl . 'movie/' . $id . '?api_key=' . $this->apiKey;

        return $this->formatMovie($this->toArray($this->request($url)));
    }

    public function tv($id)
    {

    }

    public function credits($id)
    {
        $url = $this->apiUrl . 'movie/' . $id . '/credits?api_key=' . $this->apiKey;

        return $this->toArray($this->request($url));
    }

    public function person($id)
    {
        $url = $this->apiUrl . 'person/' . $id . '?api_key=' . $this->apiKey;

        return $this->toArray($this->request($url));
    }

    private function formatMovie($movie)
    {
        return new Movie([
            'imdb'        => $movie['imdb_id'],
            'tmdb'        => $movie['id'],
            'title'       => $movie['title'],
            'releaseDate' => $movie['release_date'],
            'plot'        => $movie['overview'],
            'countries'   => $this->formatCountries($movie['production_countries']),
            'languages'   => $this->formatLanguages($movie['spoken_languages']),
            'genres'      => $this->formatGenres($movie['genres']),
            'runtime'     => $movie['runtime'],
            'poster'      => $this->imagePath . $movie['poster_path'],
            'tmdbRating'  => $movie['vote_average'],
            'tmdbVotes'   => $movie['vote_count'],
        ]);
    }

    private function formatCountries($countries)
    {
        $movie_countries = [];
        if (count($countries)) {
            foreach ($countries as $country) {
                $movie_countries[] = [
                    'code'    => $country['iso_3166_1'],
                    'country' => $country['name'],
                ];
            }
        }

        return $movie_countries;
    }

    private function formatLanguages($languages)
    {
        $movie_languages = [];
        if (count($languages)) {
            foreach ($languages as $language) {
                $movie_languages[] = [
                    'code'     => $language['iso_639_1'],
                    'language' => $language['name'],
                ];
            }
        }

        return $movie_languages;
    }

    private function formatGenres($genres)
    {
        $movie_genres = [];
        if (count($genres)) {
            foreach ($genres as $genre) {
                $movie_genres[] = $genre['name'];
            }
        }

        return $movie_genres;
    }
}
