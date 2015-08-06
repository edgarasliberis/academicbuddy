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
use AB\Bundle\ApiEntity\ApiGroup;
use AB\Bundle\ApiEntity\ApiUser;
use AB\Bundle\ApiEntity\ApiGroupCollection;
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
        $groups = ApiGroupCollection::fromGroupArray($em->getRepository('ABBundle:Group')->findAll());
        return new Response($this->serializer->serialize($groups, 'json'));
    }

    public function createGroupAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $group = new Group;
        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();

        return new Response($group->getId(), Response::HTTP_CREATED);
    }

    public function deleteAllGroupsAction() {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('ABBundle:Group')->findAll();

        foreach ($groups as $group) {
            $em->remove($group);
        }
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    public function getGroupAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $group = $em->find('ABBundle:Group', $id);
        if(is_null($group))
            throw new HttpException(Response::HTTP_NOT_FOUND);

        return new Response($this->serializer->serialize($group, 'json'));
    }

    public function updateGroupAction(Request $request) {
        throw new HttpException(404);
    }

    public function deleteGroupAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $group = $em->find('ABBundle:Group', $id);
        if(is_null($group))
            throw new HttpException(Response::HTTP_NOT_FOUND);

        $em->remove($group);
        $em->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
