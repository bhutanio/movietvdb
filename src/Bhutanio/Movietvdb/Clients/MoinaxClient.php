<?php

namespace Bhutanio\Movietvdb\Clients;

class MoinaxClient extends \Moinax\TvDb\Client
{

    public function getMirror($typeMask = self::MIRROR_TYPE_XML)
    {
        $url = parent::getMirror($typeMask);

        return str_replace('http://', 'https://', $url);
    }
}
