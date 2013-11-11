<?php
namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AB\Bundle\Form\Type\MentorRegistrationType;
use AB\Bundle\Form\Type\PupilRegistrationType;
use AB\Bundle\Form\Model\MentorRegistration;
use AB\Bundle\Form\Model\PupilRegistration;
use AB\Bundle\Entity\Course;
use AB\Bundle\Entity\Mentor;
use AB\Bundle\Entity\Pupil;

class RegistrationController extends Controller
{
    /**
     * @Route("/register/mentor", name="mentor_register")
     */
    public function registerMentorAction()
    {
        $mentor = new Mentor();
        $mentor->addCourse(new Course());
        $registration = new MentorRegistration();
        $registration->setMentor($mentor);

        $form = $this->createForm(new MentorRegistrationType(), $registration, array(
            'action' => $this->generateUrl('mentor_create'),
        ));

        return $this->render(
            'ABBundle:Registration:register.mentor.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/pupil", name="pupil_register")
     */
    public function registerPupilAction()
    {
        $form = $this->createForm(new PupilRegistrationType(), new PupilRegistration(), array(
            'action' => $this->generateUrl('pupil_create'),
        ));

        return $this->render(
            'ABBundle:Registration:register.pupil.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/mentor/create", name="mentor_create")
     */
    public function createMentorAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new MentorRegistrationType(), new MentorRegistration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $mentor = $registration->getMentor();
            $mentor->setActive(0);
            //TODO: get phase from global config
            $mentor->setPhase(1);

            foreach($mentor->getCourses() as $course) {
                // Get university by name
                $university = $course->getUniversity();
                $university->addCourse($course);
                $course->setMentor($mentor);

                $em->persist($university);
                $em->persist($course);
            }
            $em->persist($mentor);
            $em->flush();


            // Send confirmation email
            $confirmationMessage = \Swift_Message::newInstance()
                ->setSubject('Academic Brother: tavo registracija sėkminga!')
                ->setFrom('academicbrother@gmail.com')
                ->setTo($mentor->getEmail())
                ->setBody(
                    $this->renderView(
                        'ABBundle:Email:register.mentor.confirmation.html.twig'
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($confirmationMessage);

            return $this->render(
                'ABBundle:Registration:register.mentor.html.twig',
                array('form' => $form->createView(), 'success' => true)
            );
        }

        return $this->render(
            'ABBundle:Registration:register.mentor.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/pupil/create", name="pupil_create")
     */
    public function createPupilAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new PupilRegistrationType(), new PupilRegistration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $pupil = $registration->getPupil();
            $pupil->setActive(0);
            //TODO: get phase from global config
            $pupil->setPhase(1);

            $em->persist($pupil);
            $em->flush();

            // Send confirmation email
            $confirmationMessage = \Swift_Message::newInstance()
                ->setSubject('Academic Brother: tavo registracija sėkminga!')
                ->setFrom('academicbrother@gmail.com')
                ->setTo($pupil->getEmail())
                ->setBody(
                    $this->renderView(
                        'ABBundle:Email:register.pupil.confirmation.html.twig'
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($confirmationMessage);

            return $this->render(
                'ABBundle:Registration:register.pupil.html.twig',
                array('form' => $form->createView(), 'success' => true)
            );
        }

        return $this->render(
            'ABBundle:Registration:register.pupil.html.twig',
            array('form' => $form->createView())
        );
    }
}