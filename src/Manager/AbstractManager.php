<?php

namespace Kematjaya\RoutingManager\Manager;

use Kematjaya\RoutingManager\Reader\ReaderInterface;
use Kematjaya\RoutingManager\Menu\MenuInterface;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
abstract class AbstractManager implements ManagerInterface
{
    /**
     *
     * @var ReaderInterface 
     */
    protected $reader;
    
    public function __construct(ReaderInterface $reader) 
    {
        if($reader->getData()->first() and !$reader->getData()->first() instanceof MenuInterface)
        {
            throw new \Exception(sprintf("ReaderInterface::getData() collections must instance of %s", MenuInterface::class));
        }
        
        $this->reader = $reader;
    }
    
    
}
