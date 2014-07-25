<?php
/** 
 * @author Andrius Dagys <andriusdag@gmail.com>
 */

namespace AB\Bundle\Controller;

use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller {

    public function settingsAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new ChangePasswordFormType(get_class($user)), $user, array(
            'action' => $this->generateUrl('settings'))
        );
        $success = false;
        if ($request->isMethod('POST')) {
            $userManager = $this->container->get('fos_user.user_manager');
            $form->handleRequest($request);
            if ($form->isValid()) {
                $userManager->updateUser($user);
                $success = true;
            }
        }
        return $this->render('ABBundle:Profile:settings.html.twig',
                             array('form' => $form->createView(), 'success' => $success));
    }
} 