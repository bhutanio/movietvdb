<?php

namespace Bhutanio\Movietvdb;

use Bhutanio\Movietvdb\Contracts\MovieInterface;

class TmdbClient extends Client implements MovieInterface
{
    protected $apiUrl = 'api.themoviedb.org/3/';
    protected $apiSecure = true;

    public function __construct($apiKey)
    {
        parent::__construct($this->apiUrl, $apiKey);
    }

    public function find($key)
    {
        $this->validateImdbId($key);
        $url = $this->apiUrl.'find/'.$key.'?api_key='.$this->apiKey.'&external_source=imdb_id';

        return $this->toArray($this->request($url));
    }

    public function movie($id)
    {
        $url = $this->apiUrl.'movie/'.$id.'?api_key='.$this->apiKey;

        return $this->toArray($this->request($url));
    }

    public function credits($id)
    {
        $url = $this->apiUrl.'movie/'.$id.'/credits?api_key='.$this->apiKey;

        return $this->toArray($this->request($url));
    }

    public function person($id)
    {
        $url = $this->apiUrl.'person/'.$id.'?api_key='.$this->apiKey;

        return $this->toArray($this->request($url));
    }
}
