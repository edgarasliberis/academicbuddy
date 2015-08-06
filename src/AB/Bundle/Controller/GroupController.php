<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use AB\Bundle\Entity\User;
use AB\Bundle\Entity\Group;
use JMS\Serializer\SerializerBuilder;

class GroupController extends TokenAuthenticatedController
{
    private $serializer;

    public function __construct() {
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function getCsrfId() {
        return "GroupController";
    }

    // Proper way would be to implement automatic entity serialisation 
    // and deserialisation through JMS\Serializer events, 
    // but let's not overkill with OOP here.

    public static function serializeUser(User $user) {
        return array( 
            'name' => $user->getFirstName() . " " . $user->getLastName(),
            'email' => $user->getEmail()
        );
    }

    public static function serializeGroup(Group $group) {
        return array(
            'mentor' => serializeUser($group->getMentor()),
            'secondaryMentor' => serializeUser($group->getSecondaryMentor()),
            'pupils' => array_map(function($u) { return static::serializeUser($u); }, $group->getPupils)
        );
    }

    public function issueCsrfTokenAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        return parent::issueCsrfTokenAction($request);
    }

    public function listGroupsAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $groups = array_map(function($g) { return static::serializeGroup($g); }, 
            $em->getRepository('ABBundle:User')->findAll());

        return new Response($this->serializer->serialize($groups, 'json'));
    }

    public function createGroupAction() {
        throw new HttpException(404);
    }

    public function deleteAllGroupsAction() {
        throw new HttpException(404);
    }

    public function getGroupAction() {
        throw new HttpException(404);
    }

    public function updateGroupAction() {
        throw new HttpException(404);
    }

    public function deleteGroupAction() {
        throw new HttpException(404);
    }
}
