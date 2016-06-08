<?php
namespace AB\Bundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class Builder implements ContainerAwareInterface
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;
    
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'navbar-nav nav');
		
        $menu->addChild('Apie Oksbridžo etapą', array(
            'route' => 'about_oxbridge'
        ))->setExtra('translation_domain', 'messages');

        $menu->addChild('Apie II etapą (JK)', array(
            'route' => 'about_uk'
        ))->setExtra('translation_domain', 'messages');
		
        $menu->addChild('Parama', array(
            'route' => 'support'
        ))->setExtra('translation_domain', 'messages');
        
        $menu->addChild('Mentoriai', array(
            'route' => 'mentor_list'
        ))->setExtra('translation_domain', 'messages');

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