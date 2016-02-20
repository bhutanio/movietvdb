<?php

namespace Bhutanio\Movietvdb;

class Scrapper
{
    public $type;

    protected $imdb;
    protected $tmdb;
    protected $tvdb;

    public function __construct()
    {

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