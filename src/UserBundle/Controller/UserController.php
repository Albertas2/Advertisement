<?php
namespace UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends BaseController
{
    /**
     * @param Request $request
     *
     * @Route("/user/advertisements")
     * @Template("@Advertisement/default/index.html.twig")
     *
     * @return Response
     */
    public function listAdvertisementsAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user)
        {
            $this->render($this->generateUrl('fos_user_security_login'));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $dql   = "SELECT a FROM AdvertisementBundle:Advertisement a WHERE a.user = :user";
        $query = $em->createQuery($dql)->setParameter('user', $user);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return ['pagination' => $pagination];
    }
    
}
