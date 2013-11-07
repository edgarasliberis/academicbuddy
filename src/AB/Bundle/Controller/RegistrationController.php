<?php
namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AB\Bundle\Form\Type\MentorRegistrationType;
use AB\Bundle\Form\Model\MentorRegistration;
use AB\Bundle\Entity\Course;
use AB\Bundle\Entity\Mentor;

class RegistrationController extends Controller
{
    /**
     * @Route("/mentor/register", name="mentor_register")
     */
    public function registerAction()
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
     * @Route("/mentor/register/create", name="mentor_create")
     */
    public function createAction(Request $request)
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

            return $this->redirect("/");
        }

        return $this->render(
            'ABBundle:Registration:register.mentor.html.twig',
            array('form' => $form->createView())
        );
    }
}