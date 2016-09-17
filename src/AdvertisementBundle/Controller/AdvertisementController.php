<?php

namespace AdvertisementBundle\Controller;

use AdvertisementBundle\Form\Type\AdvertisementType;
use FOS\UserBundle\Controller\RegistrationController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use AdvertisementBundle\Entity\Advertisement;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Constraints\Date;

class AdvertisementController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="homepage")
     * @Template("AdvertisementBundle:default:index.html.twig")
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $dql   = "SELECT a FROM AdvertisementBundle:Advertisement a";
        $query = $em->createQuery($dql);


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );
        
        return ['pagination' => $pagination];
    }

    /**
     * @param  Request $request
     *
     * @Route("/advertisement/create")
     * @Template("@Advertisement/Form/create.html.twig");
     *
     * @return Response
     */
    
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        
        if (!$user)
        {
           $this->render($this->generateUrl('fos_user_security_login'));
        }

        $em = $this->getDoctrine()->getEntityManager();

        $advertisement = new Advertisement();
        $form = $this->createForm(AdvertisementType::class, $advertisement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $advertisement = $form->getData();
            $advertisement->setUser($user);
            $advertisement->setPostingDate(new \DateTime());
            $em->persist($advertisement);
            $em->flush();

            $this->addFlash('success', 'Advertisement "'.$advertisement->getTitle().'" created successfully');

            return $this->redirect($this->generateUrl('homepage'));
        }
        
        return ['form' => $form->createView()];
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @Route("/advertisement/edit/{id}")
     *
     * @return Response
     */

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->getUser();
        $advertisement = $em->getRepository('AdvertisementBundle:Advertisement')->find($id);

        if (!$advertisement){
            throw new NotFoundHttpException('There is no advertisement with ID '. $id);
        }

        if ($user->getId() != $advertisement->getUser()->getId())
        {
            throw new AccessDeniedException('Access Denied');
        }

        $form = $this->createForm(AdvertisementType::class, $advertisement);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {

            $em->persist($advertisement);
            $em->flush();

            $this->addFlash('success', 'Advertisement "'.$advertisement->getTitle().'" updated successfully');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('@Advertisement/Form/edit.html.twig', [
            'id'   => $id,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $id
     * 
     * @Route("/advertisement/delete/{id}")
     * @return Response
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->getUser();
        $advertisement = $em->getRepository('AdvertisementBundle:Advertisement')->find($id);

        if (!$advertisement){
            throw new NotFoundHttpException('There is no advertisement with ID '. $id);
        }

        if ($user->getId() != $advertisement->getUser()->getId())
        {
            throw new AccessDeniedException('Access Denied');
        }
        
        $em->remove($advertisement);
        $em->flush($advertisement);

        $this->addFlash('danger', 'Advertisement "'.$advertisement->getTitle().'" deleted successfully');

        return $this->redirect($this->generateUrl('homepage'));
    }
}
