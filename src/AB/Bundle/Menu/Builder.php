<?php
namespace AB\Bundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'navbar-nav');
        
        $menu->addChild('Pradžia', array(
            'route' => 'home'
        ));
        $menu->addChild('Apie', array(
            'route' => 'about'
        ));

        return $menu;
    }
}