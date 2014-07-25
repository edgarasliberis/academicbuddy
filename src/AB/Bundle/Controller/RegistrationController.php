<?php
namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AB\Bundle\Form\Type\MentorRegistrationType;
use AB\Bundle\Form\Type\PupilRegistrationType;
use AB\Bundle\Form\Model\MentorRegistration;
use AB\Bundle\Form\Model\PupilRegistration;
use AB\Bundle\Entity\Course;
use AB\Bundle\Entity\Mentor;

class RegistrationController extends Controller
{
    public function registerMentorAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AB\Bundle\Entity\Mentor');
    }

    public function registerPupilAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AB\Bundle\Entity\Pupil');
    }

}
//    /**
//     * @Route("/register/mentor", name="mentor_register")
//     */
//    public function registerMentorAction()
//    {
//        $mentor = new Mentor();
//        $mentor->addCourse(new Course());
//        $registration = new MentorRegistration();
//        $registration->setMentor($mentor);
//
//        $form = $this->createForm(new MentorRegistrationType(), $registration, array(
//            'action' => $this->generateUrl('mentor_create'),
//        ));
//
//        return $this->render(
//            'ABBundle:Registration:register.mentor.html.twig',
//            array('form' => $form->createView())
//        );
//    }
//
//    /**
//     * @Route("/register/pupil", name="pupil_register")
//     */
//    public function registerPupilAction()
//    {
//        $form = $this->createForm(new PupilRegistrationType(), new PupilRegistration(), array(
//            'action' => $this->generateUrl('pupil_create'),
//        ));
//
//        return $this->render(
//            'ABBundle:Registration:register.pupil.html.twig',
//            array('form' => $form->createView())
//        );
//    }
//
//    /**
//     * @Route("/register/mentor/create", name="mentor_create")
//     */
//    public function createMentorAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $form = $this->createForm(new MentorRegistrationType(), new MentorRegistration());
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $registration = $form->getData();
//
//            $mentor = $registration->getMentor();
//            //TODO: get phase from global config
//            $mentor->setPhase(1);
//
//            // Generate a placeholder password
//            // A new password will be generated and sent to the user on activation
//            //TODO: code duplication - move this to a separate helper?
//            $generator = new SecureRandom();
//            $random = $generator->nextBytes(10);
//            $factory = $this->get('security.encoder_factory');
//            $encoder = $factory->getEncoder($mentor);
//
//            $password = $encoder->encodePassword($random, $mentor->getSalt());
//            $mentor->setPassword($password);
//
//            foreach($mentor->getCourses() as $course) {
//                // Get university by name
//                $university = $course->getUniversity();
//                $university->addCourse($course);
//                $course->setMentor($mentor);
//
//                $em->persist($university);
//                $em->persist($course);
//            }
//            $em->persist($mentor);
//            $em->flush();
//
//            // Send confirmation email
//            $confirmationMessage = \Swift_Message::newInstance()
//                ->setSubject('Academic Brother: tavo registracija sėkminga!')
//                ->setFrom('academicbrother@gmail.com')
//                ->setTo($mentor->getEmail())
//                ->setBody(
//                    $this->renderView(
//                        'ABBundle:Email:register.mentor.confirmation.html.twig'
//                    ),
//                    'text/html'
//                )
//            ;
//            $this->get('mailer')->send($confirmationMessage);
//
//            // Send activation email
//            $confirmationMessage = \Swift_Message::newInstance()
//                ->setSubject('[Nauja registracija][Mentorius]')
//                ->setFrom('academicbrother@gmail.com')
//                ->setTo('academicbrother@gmail.com')
//                ->setBody(
//                    $this->renderView(
//                        'ABBundle:Email:activate.mentor.review.html.twig',
//                        array('user' => $mentor)
//                    ),
//                    'text/html'
//                )
//            ;
//            $this->get('mailer')->send($confirmationMessage);
//
//            return $this->render(
//                'ABBundle:Registration:register.mentor.html.twig',
//                array('form' => $form->createView(), 'success' => true)
//            );
//        }
//
//        return $this->render(
//            'ABBundle:Registration:register.mentor.html.twig',
//            array('form' => $form->createView())
//        );
//    }
//
//    /**
//     * @Route("/register/pupil/create", name="pupil_create")
//     */
//    public function createPupilAction(Request $request)
//    {
//        $em = $this->getDoctrine()->getEntityManager();
//
//        $form = $this->createForm(new PupilRegistrationType(), new PupilRegistration());
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $registration = $form->getData();
//
//            $pupil = $registration->getPupil();
//            //TODO: get phase from global config
//            $pupil->setPhase(1);
//
//            // Generate a placeholder password
//            // A new password will be generated and sent to the user on activation
//            //TODO: code duplication - move this to a separate helper?
//            $generator = new SecureRandom();
//            $random = $generator->nextBytes(10);
//            $factory = $this->get('security.encoder_factory');
//            $encoder = $factory->getEncoder($pupil);
//
//            $password = $encoder->encodePassword($random, $pupil->getSalt());
//            $pupil->setPassword($password);
//
//            $em->persist($pupil);
//            $em->flush();
//
//            // Send confirmation email
//            $confirmationMessage = \Swift_Message::newInstance()
//                ->setSubject('Academic Brother: tavo registracija sėkminga!')
//                ->setFrom('academicbrother@gmail.com')
//                ->setTo($pupil->getEmail())
//                ->setBody(
//                    $this->renderView(
//                        'ABBundle:Email:register.pupil.confirmation.html.twig'
//                    ),
//                    'text/html'
//                )
//            ;
//            $this->get('mailer')->send($confirmationMessage);
//
//            return $this->render(
//                'ABBundle:Registration:register.pupil.html.twig',
//                array('form' => $form->createView(), 'success' => true)
//            );
//        }
//
//        return $this->render(
//            'ABBundle:Registration:register.pupil.html.twig',
//            array('form' => $form->createView())
//        );
//    }
//
//    /**
//     * @Route("/activate/{type}/{key}", name="activate")
//     */
//    public function activateAction($type, $key) {
//        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository('ABBundle:User')
//                   ->findOneBy(array('activationKey' => $key));
//
//        if ($user == null) {
//            return $this->render(
//                'ABBundle:Registration:activate.user.html.twig',
//                array('error' => 'Nepavyko rasti vartotojo')
//            );
//        }
//
//        if ($user->getIsActive()) {
//            return $this->render(
//                'ABBundle:Registration:activate.user.html.twig',
//                array('error' => 'Šis vartotojas jau aktyvuotas')
//            );
//        }
//        $user->setIsActive(true);
//
//        // Generate a new temp password
//        $tempPassword = substr(md5(time()),0,6);
//
//        $factory = $this->get('security.encoder_factory');
//        $encoder = $factory->getEncoder($user);
//        $password = $encoder->encodePassword($tempPassword, $user->getSalt());
//
//        $user->setPassword($password);
//        $em->flush();
//
//        // Send confirmation email
//        $messageTemplate = 'ABBundle:Email:activate.mentor.confirmation.html.twig';
//        if ($type == 'pupil') {
//            $messageTemplate = 'ABBundle:Email:activate.pupil.confirmation.html.twig';
//        }
//
//        $confirmationMessage = \Swift_Message::newInstance()
//            ->setSubject('Academic Brother: tavo registracija patvirtinta!')
//            ->setFrom('academicbrother@gmail.com')
//            ->setTo($user->getEmail())
//            ->setBody(
//                $this->renderView(
//                    $messageTemplate,
//                    array('password' => $tempPassword)
//                ),
//                'text/html'
//            )
//        ;
//        $this->get('mailer')->send($confirmationMessage);
//
//        return $this->render(
//            'ABBundle:Registration:activate.user.html.twig'
//        );
//    }
//}
