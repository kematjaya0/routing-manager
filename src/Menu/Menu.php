<?php

namespace Kematjaya\RoutingManager\Menu;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class Menu implements MenuInterface
{
    /**
     *
     * @var Collection
     */
    private $childs;
    
    /**
     *
     * @var string
     */
    private $route;
    
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var bool
     */
    private $isActive;
    
    /**
     *
     * @var string
     */
    private $icon;
    
    private $roles = [];
    
    public function __construct() 
    {
        $this->childs = new ArrayCollection();
    }
    
    public function addChild(MenuInterface $menu): MenuInterface 
    {
        if(!$this->childs->offsetExists($menu->getRoute()))
        {
            $this->childs->offsetSet($menu->getRoute(), $menu);
        }
        
        return $this;
    }

    public function getChilds(): Collection 
    {
        return $this->childs;
    }

    public function setChilds(Collection $childs): MenuInterface
    {
        $this->childs = $childs;
        
        return $this;
    }
    
    public function getName(): ?string 
    {
        return $this->name;
    }

    public function getRoute(): ?string 
    {
        return $this->route;
    }

    public function isActive(): bool 
    {
        return $this->isActive;
    }
    
    public function setRoute(string $route): MenuInterface 
    {
        $this->route = $route;
        
        return $this;
    }

    public function setName(string $name): MenuInterface 
    {
        $this->name = $name;
        
        return $this;
    }

    public function setIsActive(bool $isActive): MenuInterface  
    {
        $this->isActive = $isActive;
        
        return $this;
    }

    function getIcon(): string 
    {
        return $this->icon;
    }

    function setIcon(string $icon): self 
    {
        $this->icon = $icon;
        
        return $this;
    }

    function getRoles() :array
    {
        return $this->roles;
    }

    function setRoles(array $roles): MenuInterface 
    {
        $this->roles = $roles;
        
        return $this;
    }



}
