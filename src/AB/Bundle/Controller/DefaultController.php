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

    public function userExportAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        return $this->render('ABBundle:Default:user.export.html.twig');
    }

    public function userDataAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        // Process query
        $men = $request->query->get('mentors') === 'true'? true : false;
        $pup = $request->query->get('pupils') === 'true'? true : false;
        $enb = $request->query->get('enabled') === 'true'? true : false;
        $nen = $request->query->get('notenabled') === 'true'? true : false;

        $any = ($men || $pup) && ($enb || $nen);
        $users = array();

        // Retrieve data
        if($any) {
            $allStatuses = $enb && $nen;
            $allRoles = $men && $pup;

            $status = $allStatuses? '_' : (($enb || !$nen)? '1' : '0');
            $role = $allRoles? '%' : ($men? '%"ROLE_MENTOR"%' : '%"ROLE_PUPIL"%');

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT user FROM ABBundle:User user
                WHERE user.enabled LIKE :enabled
                AND user.roles LIKE :role'
            )->setParameter('enabled', $status)
             ->setParameter('role', $role);
            $users = $query->getResult();
        }

        // Output in a requested format
        // CSV
        if ($request->query->get('type') === 'csv') {
            if(!($men xor $pup)) {
                return new HttpException(500, "Only mentors' or pupils' export can be requested, but not both or neither.");
            }

            $response = new StreamedResponse();
            $response->setCallback(function() use ($users, $men, $pup) {
                $handle = fopen('php://output', 'w+');
                $del = ',';
                $esc = '"';

                if($men) {
                    // Put mentors' table headings
                    fputcsv($handle, array('First name', 'Last name', 'Email',
                        'Facebook', 'LinkedIn',
                        'Home City', 'About', 'School Name', 
                        'School City', 'School Grad Year', 'Course Category', 
                        'Course Name', 'Start Year', 'Grad Year', 'University'), $del, $esc);
                    foreach($users as $user)
                    {
                        // Mentor can have multiple courses listed.
                        // Output that mentor multiple times for each course.
                        foreach($user->getCourses() as $course) {
                            fputcsv($handle, 
                                array($user->getFirstName(), $user->getLastName(), $user->getEmail(), 
                                    $user->getFacebookId(), $user->getLinkedinId(),
                                    $user->getHomeCity(), $user->getAbout(), $user->getSchoolName(), 
                                    $user->getSchoolCity(), $user->getSchoolGraduationYear(), $course->getCourseCategory(),
                                    $course->getName(), $course->getStartYear(), $course->getGraduationYear(), $course->getUniversity()), 
                                $del, $esc);
                        }
                        
                    }
                } else if ($pup) {
                    // Put pupils' table headings
                    fputcsv($handle, array('First name', 'Last name', 'Email', 
                        'Home City', 'Interests', 'School Name', 
                        'School City', 'Grad year', 'School Grade', 
                        'Course Category', 'Motivation', 'University Region', 'Course Name'), $del, $esc);
                    foreach($users as $user)
                    {
                        fputcsv($handle, 
                            array($user->getFirstName(), $user->getLastName(), $user->getEmail(), 
                                $user->getHomeCity(), $user->getAbout(), $user->getSchoolName(), 
                                $user->getSchoolCity(), $user->getSchoolGraduationYear(), $user->getSchoolGrade(),
                                $user->getCourseCategory(), $user->getMotivation(), $user->getUniversityRegion(), $user->getCourseName()),
                            $del, $esc);
                    }
                }

                fclose($handle);
            });
         
            $filename = ($men? "mentors" : "pupils") . date('-Ymd-Hi') . '.csv';
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition','attachment; filename="'.$filename.'"');
         
            return $response;
        }
        // List of emails
        else if ($request->query->get('type') === 'email') {
            $formatUser = function($user) { 
                return $user->getFirstName() . ' ' . $user->getLastName() . ' <' . $user->getEmail() . '>'; 
            };
            $respStrs = array_map($formatUser, $users);

            $response = new Response(implode(",\n", $respStrs));
            return $response;
        }

        return null;
    }        
}
