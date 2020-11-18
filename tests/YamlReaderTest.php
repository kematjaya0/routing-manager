<?php

namespace Kematjaya\RoutingManager\Tests;

use Kematjaya\RoutingManager\Menu\MenuInterface;
use Kematjaya\RoutingManager\Reader\YamlReader;
use Kematjaya\RoutingManager\Reader\ReaderInterface;
use Kematjaya\RoutingManager\Manager\RoutingManager;
use PHPUnit\Framework\TestCase;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class YamlReaderTest extends TestCase
{
    public function testReader()
    {
        $reader = new YamlReader(__DIR__);
        $this->assertTrue(!$reader->getData()->isEmpty());
        $this->assertInstanceOf(MenuInterface::class, $reader->getData()->first());
        
        return $reader;
    }
    
    /**
     * @depends testReader
     */
    public function testManager(ReaderInterface $reader)
    {
        $manager = new RoutingManager($reader);
        $this->assertTrue(!$manager->getAll()->isEmpty());
        $this->assertInstanceOf(MenuInterface::class, $manager->getAll()->first());
    }
}
