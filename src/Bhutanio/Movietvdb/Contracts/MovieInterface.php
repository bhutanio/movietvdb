<?php

namespace Bhutanio\Movietvdb\Contracts;

interface MovieInterface
{
    public function find($key);

    public function movie($id);

    public function credits($id);

    public function person($id);
}
