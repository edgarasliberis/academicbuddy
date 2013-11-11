<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('ABBundle:Default:index.html.twig', array('name' => 'home'));
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction() 
    {
    	return $this->render('ABBundle:Default:index.html.twig', array('name' => 'about'));	
    }
}
