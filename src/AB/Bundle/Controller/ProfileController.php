<?php
/** 
 * @author Andrius Dagys <andriusdag@gmail.com>
 * @author Edgaras Liberis <el398@cam.ac.uk>
 */

namespace AB\Bundle\Controller;

use FOS\UserBundle\Form\Type\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AB\Bundle\Entity\Pupil;
use AB\Bundle\Entity\Mentor;
use AB\Bundle\Form\Type\PupilProfileType;
use AB\Bundle\Form\Type\MentorProfileType;

class ProfileController extends Controller {

    public function settingsAction($id, Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        // Disallow non-admins editing other users
        if(false === $this->get('security.context')->isGranted('ROLE_ADMIN') && !is_null($id)) {
            throw new AccessDeniedException();
        }

        $userId = is_null($id)? $this->container->get('security.context')->getToken()->getUser()->getId() : $id;
        $user = $this->container->get('pugx_user_manager')->findUserBy(array('id' => $userId));

        if(is_null($user))
            throw $this->createNotFoundException('User with given ID is not found!');

        //$userClass = $this->container->get('pugx_user.manager.user_discriminator')->getClass($user);
        //exit(\Doctrine\Common\Util\Debug::dump($user->getAbout()));

        $passChangeForm = $this->createForm(new ChangePasswordFormType(get_class($user)), $user, array(
            'action' => $request->getRequestUri())
        );
        
        $isPupil = $user instanceof Pupil;

        $detailsChangeForm = $this->createForm(
            $isPupil? new PupilProfileType(get_class($user)) : new MentorProfileType(get_class($user)),
            $user, 
            array('action' => $request->getRequestUri())
        );

        $success = false;
        if ($request->isMethod('POST')) {
            if($request->request->has('user_details_edit')) {
                $form = $detailsChangeForm;
            } else {
                $form = $passChangeForm;
            }
            $userManager = $this->container->get('pugx_user_manager');
            $form->handleRequest($request);
            if ($form->isValid()) {
                $userManager->updateUser($user);
                $success = true;
            }
        }
        return $this->render('ABBundle:Profile:settings.html.twig',
                             array('passForm' => $passChangeForm->createView(), 
                                'detailsForm' => $detailsChangeForm->createView(), 
                                'template' => $isPupil? 'pupil' : 'mentor',
                                'success' => $success));
    }

    public function deleteAction($id, Request $request) {
        if(false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $userManager = $this->container->get('pugx_user_manager');
        $user = $userManager->findUserBy(array('id' => $id));
        if(is_null($user))
            throw $this->createNotFoundException('User with given ID is not found!');

        $form = $this->get('form.factory')->createBuilder('form', array('action' => $request->getRequestUri()))->getForm();
        $success = false;
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {
                $mgr = $this->getDoctrine()->getManager();
                $mgr->remove($user);
                $mgr->flush();
                $success = true;
            }
        }

        return $this->render('ABBundle:Profile:delete.html.twig', array('form' => $form->createView(), 'success' => $success));
    }
} 