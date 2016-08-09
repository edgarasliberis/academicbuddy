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

        $menu->addChild('Stojimas į JK')->setExtra('translation_domain', 'messages')
        ->setAttribute('dropdown', true);

        $menu['Stojimas į JK']->addChild('Oksbridžo etapas', array(
            'route' => 'about_oxbridge'
        ))->setExtra('translation_domain', 'messages');

        $menu['Stojimas į JK']->addChild('JK (II-asis) etapas', array(
            'route' => 'about_uk'
        ))->setExtra('translation_domain', 'messages');

        $menu['Stojimas į JK']->addChild('Mentoriai', array(
            'route' => 'mentor_list'
        ))->setExtra('translation_domain', 'messages');

        $menu->addChild('Stojimas į JAV')->setExtra('translation_domain', 'messages')
        ->setAttribute('dropdown', true);

        $menu['Stojimas į JAV']->addChild('Apie JAV etapą', array(
            'route' => 'about_usa'
        ))->setExtra('translation_domain', 'messages');

        $menu['Stojimas į JAV']->addChild('JAV mentoriai', array(
            'route' => 'about_usa_mentors'
        ))->setExtra('translation_domain', 'messages');

        $menu['Stojimas į JAV']->addChild('Registracija', array(
            'uri' => 'https://goo.gl/forms/thkpGrMSRJiHLdmZ2'
        ))->setExtra('translation_domain', 'messages');

        $menu->addChild('Apie mus', array(
            'route' => 'about_ab'
        ))->setExtra('translation_domain', 'messages');
		
        /*$menu->addChild('Parama', array(
            'route' => 'support'
        ))->setExtra('translation_domain', 'messages');*/

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