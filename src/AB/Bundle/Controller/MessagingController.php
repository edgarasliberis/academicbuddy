<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MessagingController extends Controller
{
    public function sendMessageAction(Request $request, $mentorId)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }
        $form = $this->createFormBuilder()
            ->add('message', 'textarea')
            ->getForm();
        $success = false;
        $error = null;
        $mentorName = null;
        $em = $this->getDoctrine()->getManager();
        $mentor = $em->getRepository('ABBundle:Mentor')->findOneById($mentorId);
        if ($mentor == null) {
            $error = "Mentorius nerastas";
        }
        else $mentorName = $mentor->getFirstName()." ".$mentor->getLastName();
        if ($error == null && 'POST' === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $this->get('security.context')->getToken()->getUser();
                $subject = 'Academic Buddy: žinutė nuo '.$user->getFirstName().' '.$user->getLastName();

                $data = $form->getData();
                $messageText = $data['message'];
                $messageText.= "\n\n---\nAtsakius į šį laišką, tavo žinutė bus nusiųsta tiesiai į siuntėjo el pašto dėžutę\n";

                $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom('academic.buddy@gmail.com')
                    ->setTo($mentor->getEmail())
                    ->setReplyTo($user->getEmail())
                    ->setBody($messageText);
                $this->get('mailer')->send($message);
                $success = true;
            }
            else $error = "Klaida. Netinkamai užpildytas žinutės laukelis";
        }
        return $this->render('ABBundle:Default:message.html.twig', array(
            'mentorId' => $mentorId, 'mentorName' => $mentorName,
            'form' => $form->createView(),
            'error' => $error, 'success' => $success
        ));
    }
}
