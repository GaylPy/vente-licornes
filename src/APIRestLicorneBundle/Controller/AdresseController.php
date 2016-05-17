<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Adresse;
use APIRestLicorneBundle\Form\AdresseType;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdresseController extends Controller
{

    /**
     * Renvoi la liste compl�te des adresses
     *
     * @return array
     * @View()
     */
   public function getAdressesAction(){
       $em = $this->getDoctrine()->getManager();

       $adresses = $em->getRepository('APIRestLicorneBundle:Adresse')->findAll();

       return array('adresses' => $adresses);
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
     * Cr�er une adresse
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
            return $entity;
        }
        return View::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Route("/adresse/create")
     *
     */
    public function createFormClientAction(){
        $entity = new Adresse();
        $form = $this->createForm(AdresseType::class, $entity);
        return $this->render('APIRestLicorneBundle:Default:index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}