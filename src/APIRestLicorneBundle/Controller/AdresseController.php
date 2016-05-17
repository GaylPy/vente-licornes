<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Adresse;
use APIRestLicorneBundle\Form\AdresseType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdresseController extends FOSRestController
{

    /**
     * Renvoi la liste complète des adresses
     *
     * @return array
     * @View()
     */
   public function getAdressesAction(){
       $em = $this->getDoctrine()->getManager();

       $adresses = $em->getRepository('APIRestLicorneBundle:Adresse')->findAll();

       $view = $this->view(array('adresses' => $adresses), 200);

       return $this->handleView($view);
   }

    /**
     * Renvoi une adresse
     *
     * @param Adresse $adresse
     * @return array
     * @View()
     * @ParamConverter("client", class="APIRestLicorneBundle:Adresse")
     */
    public function getAdresseAction(Adresse $adresse)
    {
        return array('adresse' => $adresse);
    }

    /**
     * Créer une adresse
     *
     * @View(statusCode=201)
     * @param Request $request
     * @return Response
     *
     */
    public function postAdresseAction(Request $request)
    {
        $entity = new Adresse();
        $form = $this->createForm(AdresseType::class, $entity, array("method" => $request->getMethod()));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view = $this->view(array('adresse' => $entity), 200);

            return $this->handleView($view);
        }
        return $this->view(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Route("/adresse/create")
     *
     */
    public function createFormAdresseAction(){
        $entity = new Adresse();
        $form = $this->createForm(AdresseType::class, $entity);
        return $this->render('APIRestLicorneBundle:Default:adresse.html.twig', array(
            'form' => $form->createView()
        ));
    }
}