<?php

namespace Kematjaya\RoutingManager\Manager;

use Kematjaya\RoutingManager\Menu\MenuInterface;
use Kematjaya\RoutingManager\Reader\ReaderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class RoutingRoleManager extends AbstractManager 
{
    
    /**
     *
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    
    public function __construct(
            TokenStorageInterface $tokenStorage, 
            ReaderInterface $reader) 
    {
        $this->tokenStorage = $tokenStorage;
        parent::__construct($reader);
    }
    
    protected function isAllowed(MenuInterface $menu):bool
    {
        if(empty($menu->getRoles()))
        {
            return true;
        }
        
        if(!$this->tokenStorage->getToken()->isAuthenticated())
        {
            return false;
        }
        
        $roles = $this->tokenStorage->getToken()->getRoleNames();
        $role = array_pop($roles);
        
        return in_array($role, $menu->getRoles());
    }
    
    public function buildMenu(Collection $menus):Collection
    {
        $result = new ArrayCollection();
        foreach($menus as $menu)
        {
            if(!$menu instanceof MenuInterface)
            {
                continue;
            }
            
            if(!$menu->getChilds()->isEmpty())
            {
                $menu->setChilds($this->buildMenu($menu->getChilds()));
            }
            
            if($this->isAllowed($menu))
            {
                $result->add($menu);
            }
        }
        
        return $result;
    }
    
    public function getAll():Collection
    {
        $menus = $this->buildMenu($this->reader->getData());
        
        //dump($menus);exit;
        
        
        return $menus;
    }
}
