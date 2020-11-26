<?php

namespace Kematjaya\RoutingManager\Reader;

use Kematjaya\RoutingManager\Menu\Menu;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class YamlReader implements ReaderInterface
{
    /**
     *
     * @var string 
     */
    private $directory;
    
    public function __construct(string $directory) 
    {
        $this->directory = $directory;
    }
    
    private function getArrayData():array
    {
        $fileSystem = new Filesystem();
        $libraryPath = $this->directory;
        if(!$fileSystem->exists($libraryPath))
        {
            $fileSystem->mkdir($libraryPath, 0777);
        }
        
        $filePath = $libraryPath . DIRECTORY_SEPARATOR . 'routing.yaml';
        if(!$fileSystem->exists($filePath))
        {
            throw new \Exception(sprintf("cannot find file: %s", $filePath));
        }
        
        return Yaml::parseFile($filePath);
    }
    
    public function getData(): Collection 
    {
        
        $data = $this->getArrayData();
        
        $resultSets = new ArrayCollection();
        foreach($data as $k => $v)
        {
            $roles = isset($v['roles']) ? $v['roles'] : [];
            $menu = (new Menu())
                    ->setIcon($v['icon'])
                    ->setName($v['name'])
                    ->setRoute($k)
                    ->setRoles($roles)
                    ;
            
            foreach(($v['childs']) as $key => $child)
            {
                $roles = isset($child['roles']) ? $child['roles'] : [];
                $childMenu = (new Menu())
                        ->setIcon($v['icon'])
                        ->setName($child['name'])
                        ->setRoute($key)
                        ->setRoles($roles);
                
                $menu->addChild($childMenu);
            }
            
            $resultSets->add($menu);
        }
        
        return $resultSets;
    }

}
