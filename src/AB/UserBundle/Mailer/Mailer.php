<?php

namespace AB\UserBundle\Mailer;

use AB\Bundle\Entity\Mentor;
use AB\Bundle\Entity\Pupil;
use AB\Bundle\ApiEntity\ApiGroup;
use Symfony\Component\Routing\RouterInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\TwigSwiftMailer as BaseMailer;

class Mailer extends BaseMailer
{
    /**
     * {@inheritdoc}
     */
    public function sendRegistrationConfirmationMessage(UserInterface $user)
    {
        if ($user instanceof Mentor) {
            $template = 'ABBundle:Email:register.mentor.confirmation.html.twig';
        } else if ($user instanceof Pupil) {
            $template = 'ABBundle:Email:register.pupil.confirmation.html.twig';
        }
        else {
            //TODO: Handle error
            throw new \Exception();
        }
        $this->sendMessage($template, array(), $this->parameters['fromEmail'], $user->getEmail());
    }

    /**
     * Send an email to AB administrators for user application review and approval
     *
     * @param UserInterface $user
     * @return bool
     */
    public function sendActivationMessage(UserInterface $user) {
        $url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), true);
        if ($user instanceof Mentor) {
            $template = 'ABBundle:Email:activate.mentor.review.html.twig';
        } else if ($user instanceof Pupil) {
            $template = 'ABBundle:Email:activate.pupil.review.html.twig';
        } else {
            //TODO: Handle error
            return false;
        }
        $context = array(
            'user'=> $user,
            'confirmationURL' => $url
        );
        $this->sendMessage($template, $context, $this->parameters['fromEmail'], $this->parameters['fromEmail']);
    }

    /**
     * Send an email when a user's application is approved
     *
     * @param UserInterface $user
     * @param $tempPassword
     * @return bool
     */
    public function sendActivationConfirmationMessage(UserInterface $user, $tempPassword) {
        if ($user instanceof Mentor) {
            $template = 'ABBundle:Email:activate.mentor.confirmation.html.twig';
        } else if ($user instanceof Pupil) {
            $template = 'ABBundle:Email:activate.pupil.confirmation.html.twig';
        } else {
            //TODO: Handle error
            return false;
        }
        $this->sendMessage($template, array('password' => $tempPassword, 'email' => $user->getEmail()),
                           $this->parameters['fromEmail'], $user->getEmail());
    }

    public function sendApplicationUnsuccessfulMessage(UserInterface $user) {
        assert($user instanceof Pupil);
        $this->sendMessage('ABBundle:Email:pupil.registration.unsuccessful.html.twig', array(),
            $this->parameters['fromEmail'], $user->getEmail());
    }

    public function sendMeetYourGroupMessage(ApiGroup $group) {
        $pupilNames = array_map(function($p) {
                return $p->name;
        }, $group->pupils);

        $recipients = array_merge(array($group->mentor, $group->secondaryMentor), $group->pupils);

        $recipientArray = array();
        foreach ($recipients as $r) {
            if(is_null($r)) continue;
            $recipientArray[$r->email] = $r->name;
        }

        $this->sendMessage('ABBundle:Email:meet.group.html.twig', array(
                'mentor' => $group->mentor,
                'secondaryMentor' => $group->secondaryMentor,
                'pupils' => $pupilNames),
            $this->parameters['fromEmail'], $recipientArray);
    }

    public function sendMentorInvitationMessage($mentorArray) {
        $recipientArray = array();
        $recipientArray[$mentorArray['email']] = $mentorArray['name'];

        print_r($mentorArray);

        $this->sendMessage('ABBundle:Email:mentor.invitation.html.twig', $mentorArray,
            $this->parameters['fromEmail'], $recipientArray);
    }
}
