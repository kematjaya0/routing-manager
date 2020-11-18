<?php

namespace Kematjaya\RoutingManager\Manager;

use Doctrine\Common\Collections\Collection;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class RoutingManager extends AbstractManager
{
    public function getAll():Collection
    {
        return $this->reader->getData();
    }
}
