<?php

namespace Bhutanio\Movietvdb\Clients;

use Bhutanio\Movietvdb\Contracts\MovieTvInterface;
use Bhutanio\Movietvdb\Data\Movie;

class OmdbClient extends Client implements MovieTvInterface
{

    protected $apiUrl = 'www.omdbapi.com';
    protected $apiSecure = false;

    public function __construct($apiKey = null)
    {
        parent::__construct($this->apiUrl, $apiKey);
    }

    public function find($key)
    {
        $this->validateImdbId($key);
        $url = $this->apiUrl . '/?i=' . $key . '&plot=full&r=json';

        $data = $this->toArray($this->request($url));
        if (isset($data['Response']) && $data['Response'] == 'True') {
            return $data;
        }

        return null;
    }

    public function movie($id)
    {
        return $this->formatMovie($this->find($id));
    }

    public function tv($id)
    {
        return $this->find($id);
    }

    public function credits($id)
    {
        // TODO: Implement credits() method.
    }

    public function person($id)
    {
        // TODO: Implement person() method.
    }

    private function formatMovie($movie)
    {
        return new Movie([
            'imdb'         => $movie['imdbID'],
            'title'        => $movie['Title'],
            'releaseDate'  => $movie['Released'],
            'plot'         => $movie['Plot'],
            'languages'    => $this->formatLanguages($movie['Language']),
            'genres'       => $this->formatGenres($movie['Genre']),
            'runtime'      => (float)$movie['Runtime'],
            'poster'       => $movie['Poster'],
            'videoTrailer' => null,
            'wikiUrl'      => null,
            'imdbRating'   => $movie['imdbRating'],
            'imdbVotes'    => str_replace(',', '', $movie['imdbVotes']),
        ]);
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
}