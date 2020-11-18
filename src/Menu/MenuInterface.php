<?php

namespace Kematjaya\RoutingManager\Menu;

use Doctrine\Common\Collections\Collection;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
interface MenuInterface 
{
    public function getRoute():?string;
    
    public function getName():?string;
    
    public function isActive():bool;
    
    public function setRoute(string $route): self;

    public function setName(string $name): self;

    public function setIsActive(bool $isActive): self;
    
    public function getChilds(): Collection;
    
    public function addChild(MenuInterface $menu):self;
}
