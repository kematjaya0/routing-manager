<?php

namespace Kematjaya\RoutingManager\Manager;

use Doctrine\Common\Collections\Collection;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface ManagerInterface 
{
    public function getAll():Collection;
}
