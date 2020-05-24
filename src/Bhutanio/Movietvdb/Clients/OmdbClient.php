<?php

namespace Bhutanio\Movietvdb\Clients;

use Bhutanio\Movietvdb\Contracts\MovieTvInterface;
use Bhutanio\Movietvdb\Data\Movie;
use Bhutanio\Movietvdb\Data\Tv;

class OmdbClient extends Client implements MovieTvInterface
{

    protected $apiUrl = 'www.omdbapi.com';
    protected $apiSecure = false;

    public function __construct($apiKey = null)
    {
        parent::__construct($this->apiUrl, $apiKey);
    }

    public function find($keys, $type = null)
    {
        $this->validateKeys($keys);

        $url = $this->apiUrl . '/?i=' . $keys['imdb'] . '&plot=full&r=json&apikey=' . $this->apiKey;

        $result = $this->toArray($this->request($url));
        if (isset($result['Response']) && $result['Response'] == 'True') {
            $result = array_map(function ($value) {
                if ($value == 'N/A') {
                    return null;
                }

                return $value;
            }, $result);

            return $result;
        }

        return null;
    }

    public function movie($id)
    {
        return $this->formatMovie($this->find(['imdb' => $id], 'movie'), 'movie');
    }

    public function tv($id)
    {
        return $this->formatMovie($this->find(['imdb' => $id], 'series'), 'series');
    }

    public function person($id)
    {
        //
    }

    private function formatMovie($movie, $type = 'movie')
    {
        if ($movie['Type'] != $type) {
            return ($type == 'movie') ? new Movie([]) : new Tv([]);
        }

        $data = [
            'imdb'         => $movie['imdbID'],
            'title'        => $movie['Title'],
            'releaseDate'  => $movie['Released'],
            'plot'         => $movie['Plot'],
            'languages'    => $this->formatLanguages($movie['Language']),
            'genres'       => $this->formatGenres($movie['Genre']),
            'runtime'      => (float)$movie['Runtime'],
            'poster'       => $this->resizePoster($movie['Poster']),
            'videoTrailer' => null,
            'wikiUrl'      => null,
            'rated'        => $movie['Rated'],
            'imdbRating'   => $movie['imdbRating'],
            'imdbVotes'    => str_replace(',', '', $movie['imdbVotes']),
        ];

        return ($type == 'movie') ? new Movie($data) : new Tv($data);
    }

    private function formatLanguages($languages)
    {
        $movie_languages = [];
        if (!empty($languages)) {
            $languages = explode(',', $languages);
            foreach ($languages as $language) {
                $movie_languages[] = [
                    'code'     => null,
                    'language' => trim($language),
                ];
            }
        }

        return $movie_languages;
    }

    private function formatGenres($genres)
    {
        $movie_genres = [];
        if (!empty($genres)) {
            $genres = explode(',', $genres);
            foreach ($genres as $genre) {
                $movie_genres[] = trim($genre);
            }
        }

        return $movie_genres;
    }

    private function resizePoster($poster)
    {
        return str_replace('SX300', 'SX780', $poster);
    }
}