<?php

namespace Kematjaya\RoutingManager\Tests;

use Kematjaya\RoutingManager\Menu\MenuInterface;
use Kematjaya\RoutingManager\Reader\YamlReader;
use Kematjaya\RoutingManager\Reader\ReaderInterface;
use Kematjaya\RoutingManager\Manager\RoutingManager;
use Kematjaya\RoutingManager\Manager\RoutingRoleManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
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
    
    /**
     * @depends testReader
     */
    public function testManagerRoleNonAuth(ReaderInterface $reader)
    {
        $token = $this->createConfiguredMock(TokenInterface::class, [
            'isAuthenticated' => false
        ]);
        $tokenStorage = $this->createConfiguredMock(TokenStorageInterface::class, [
            'getToken' => $token
        ]);
        
        $manager = new RoutingRoleManager($tokenStorage, $reader);
        $this->assertEquals(1, $manager->getAll()->count());
        $this->assertTrue(!$manager->getAll()->isEmpty());
        $this->assertInstanceOf(MenuInterface::class, $manager->getAll()->first());
    }
    
    /**
     * @depends testReader
     */
    public function testManagerRoleWithAuth(ReaderInterface $reader)
    {
        $token = $this->createConfiguredMock(TokenInterface::class, [
            'isAuthenticated' => true, 'getRoleNames' => ['ROLE_USER']
        ]);
        $tokenStorage = $this->createConfiguredMock(TokenStorageInterface::class, [
            'getToken' => $token
        ]);
        
        $manager = new RoutingRoleManager($tokenStorage, $reader);
        $this->assertEquals(2, $manager->getAll()->count());
        $this->assertTrue(!$manager->getAll()->isEmpty());
        $this->assertInstanceOf(MenuInterface::class, $manager->getAll()->first());
    }
}
