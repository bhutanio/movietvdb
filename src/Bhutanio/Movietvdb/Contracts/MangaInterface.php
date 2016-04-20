<?php

namespace Bhutanio\Movietvdb\Contracts;

interface MangaInterface
{
    public function find($key);

    public function manga($id);

    public function authors($id);

    public function characters($id);
}