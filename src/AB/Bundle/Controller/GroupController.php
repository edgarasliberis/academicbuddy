<?php

namespace AB\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GroupController extends Controller
{
    public function listGroupsAction() {
        throw new HttpException(404);
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
