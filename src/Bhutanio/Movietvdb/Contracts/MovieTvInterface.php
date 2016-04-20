<?php

namespace Bhutanio\Movietvdb\Contracts;

interface MovieTvInterface
{
    /**
     * Find Movie or Tv using IMDB id
     *
     * @param string $key
     * @return array
     */
    public function find($key);

    /**
     * @param $id
     * @return \Bhutanio\Movietvdb\Data\Movie
     */
    public function movie($id);

    /**
     * @param $id
     * @return \Bhutanio\Movietvdb\Data\Tv
     */
    public function tv($id);

    /**
     * @param $id
     * @return array
     */
    public function credits($id);

    /**
     * @param $id
     * @return array
     */
    public function person($id);
}