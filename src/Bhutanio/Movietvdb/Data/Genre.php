<?php

namespace Bhutanio\Movietvdb\Data;

class Genre
{
    public $genre;

    protected $movieGenres = [
        'Action',
        'Adventure',
        'Animation',
        'Biography',
        'Comedy',
        'Crime',
        'Documentary',
        'Drama',
        'Family',
        'Fantasy',
        'History',
        'Horror',
        'Music',
        'Musical',
        'Mystery',
        'Romance',
        'Sci-Fi',
        'Sport',
        'Thriller',
        'War',
        'Western',
    ];

    protected $tvGenres = [
        'Game-Show',
        'News',
        'Reality-TV',
        'Sitcom',
        'Talk-Show',
        'Thriller',
    ];

    public function __construct(array $genres)
    {
        $this->genre = $this->parseGenres($genres);
    }

    private function parseGenres($genres)
    {
        $myGenre = [];
        $genreCollection = $this->movieGenres + $this->tvGenres;
        foreach ($genres as $genre) {
            if (in_array($genre, $genreCollection)) {
                $myGenre[] = $genre;
            } elseif ($matchedGenre = $this->matchGenre($genre)) {
                $myGenre[] = $matchedGenre;
            }
        }

        return $myGenre;
    }

    private function matchGenre($genre)
    {
        switch ($genre) {
            case 'Science Fiction':
                return 'Sci-Fi';
                break;
        }

        return false;
    }
}
