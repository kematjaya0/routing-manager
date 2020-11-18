<?php

namespace Kematjaya\RoutingManager\Reader;

use Doctrine\Common\Collections\Collection;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface ReaderInterface 
{
    public function getData():Collection;
}
