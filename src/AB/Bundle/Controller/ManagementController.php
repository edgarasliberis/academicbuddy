<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Csrf\CsrfToken;

class ManagementController extends Controller
{
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

        $userType = $request->query->get('usertype');
        if(!in_array($userType, array('pupils', 'mentors', 'all'))) return null;

        $status = $request->query->get('status');
        if(!in_array($status, array('enabled', 'disabled', 'all'))) return null;


        // Get user data
        $users = $this->retrieveUserData($userType, $status);

        // Output in a requested format
        // CSV
        if ($request->query->get('type') === 'csv') {
            if($userType === 'all') {
                return new HttpException(400, "Only mentors' or pupils' export can be requested, but not both.");
            }

            $response = new StreamedResponse();
            $response->setCallback(function() use ($userType, $users){
                $this->outputCsvCallback($userType, $users);
            });
         
            $filename = $userType . date('-Ymd-Hi') . '.csv';
            $response->setStatusCode(200);
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');
         
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


    protected function retrieveUserData($userType, $status) {
        $roleArray = array(
            'all' => '%',
            'mentors' => '%"ROLE_MENTOR"%',
            'pupils' => '%"ROLE_PUPIL"%'
        );

        $statusArray = array(
            'all' => '_',
            'enabled' => '1',
            'disabled' => '0'
        );

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT user FROM ABBundle:User user
            WHERE user.enabled LIKE :enabled
            AND user.roles LIKE :role'
        )->setParameter('enabled', $statusArray[$status])
         ->setParameter('role', $roleArray[$userType]);
        return $query->getResult();
    }

    protected function outputCsvCallback($userType, $users) {
        $handle = fopen('php://output', 'w+');
        $del = ',';
        $esc = '"';

        if($userType === 'mentors') {
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
        } else if ($userType === 'pupils') {
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
    }

    public function informUnsuccessfulApplicantsAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $users = $this->retrieveUserData("pupils", "disabled");

        foreach ($users as $user) {
            $this->container->get('ab_user.mailer')->sendApplicationUnsuccessfulMessage($user);
        }

        return new Response(); // 200 OK
    }
}
