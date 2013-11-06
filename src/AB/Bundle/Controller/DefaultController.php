<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}", name="_hello")
     */
    public function indexAction($name)
    {
        return $this->render('MainBundle:Default:index.html.twig', array('name' => $name));
    }
}
