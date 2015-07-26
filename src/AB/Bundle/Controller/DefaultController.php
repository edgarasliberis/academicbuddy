<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $locale = $request->getLocale();
        return $this->render('ABBundle:Default:index.'.$locale.'.html.twig');
    }

    public function aboutOxbridgeAction(Request $request) 
    {
        $locale = $request->getLocale();
    	return $this->render('ABBundle:Default:about.oxbridge.'.$locale.'.html.twig');
    }

    public function aboutUkAction(Request $request) 
    {
        $locale = $request->getLocale();
        return $this->render('ABBundle:Default:about.uk.'.$locale.'.html.twig');
    }

    public function supportAction(Request $request) 
    {
        $locale = $request->getLocale();
    	return $this->render('ABBundle:Default:support.'.$locale.'.html.twig');
    }

    public function mentorListAction($category, $page) {
        /*if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }*/
        $onlyActivated = '';
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $onlyActivated = ' AND mentor.enabled = 1';
        }

        $em = $this->getDoctrine()->getManager();
        if ($category == 0) {
            $query = $em->createQuery(
                'SELECT mentor FROM ABBundle:Mentor mentor
                 WHERE mentor.roles NOT LIKE :role'.$onlyActivated
            )->setParameter('role', '%"ROLE_ADMIN"%');
            $mentors = $query->getResult();
        } else {
            $query = $em->createQuery(
                'SELECT mentor FROM ABBundle:Mentor mentor
                WHERE mentor.id in
                (SELECT IDENTITY(course.mentor)
                FROM ABBundle:Course course
                WHERE course.courseCategory = :categoryId)
                AND mentor.roles NOT LIKE :role'.$onlyActivated
            )->setParameter('categoryId', $category)
             ->setParameter('role', '%"ROLE_ADMIN"%');
            $mentors = $query->getResult();
        }
        $categories = $em->getRepository('ABBundle:CourseCategory')->findAll();

        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalPages = ceil(count($mentors) / $perPage);
        $mentors = array_slice($mentors, $offset, $perPage);

        return $this->render('ABBundle:Default:mentor.list.html.twig',
            array('users' => $mentors, 'page' => $page, 'total' => $totalPages, 'category' => $category, 'categories' => $categories)
        );
    }

    public function pupilListAction($category, $page) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        if ($category == 0) {
            //Show all
            $pupils = $em->getRepository('ABBundle:Pupil')->findAll();
        } else {
            $query = $em->createQuery(
                'SELECT pupil FROM ABBundle:Pupil pupil
                WHERE pupil.courseCategory = :categoryId'
            )->setParameter('categoryId', $category);
            $pupils = $query->getResult();
        }
        $categories = $em->getRepository('ABBundle:CourseCategory')->findAll();

        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $totalPages = ceil(count($pupils) / $perPage);
        $pupils = array_slice($pupils, $offset, $perPage);

        return $this->render('ABBundle:Default:pupil.list.html.twig',
            array('users' => $pupils, 'page' => $page, 'total' => $totalPages, 'category' => $category, 'categories' => $categories)
        );
    }
}
