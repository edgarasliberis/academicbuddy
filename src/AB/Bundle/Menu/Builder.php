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
		
        $menu->addChild('Apie Oksbridžo etapą', array(
            'route' => 'about_oxbridge'
        ));

        $menu->addChild('Apie II etapą (JK)', array(
            'route' => 'about_uk'
        ));
		
        $menu->addChild('Parama', array(
            'route' => 'support'
        ));
        
        $menu->addChild('Mentoriai', array(
            'route' => 'mentor_list'
        ));

        /*$securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Moksleiviai', array(
                'route' => 'pupil_list'
            ));

            $menu->addChild('El. paštai', array(
                'route' => 'user_export'
            ));
        }*/
        return $menu;
    }
}