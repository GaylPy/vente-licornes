<?php

namespace APIRestLicorneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Types\Type;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use APIRestLicorneBundle\Entity\Categorie;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @RouteResource("Categorie")
 * */

class CategorieController extends FOSRestController
{
    /**
     * @return array
     * @View()
     *
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('APIRestLicorneBundle:Categorie')->findAll();

        $view = $this->view(array('categories' => $categories), 200);

        return $this->handleView($view);

    }

    /**
     * @param Categorie $categorie
     * @return array
     * @View()
     * @ParamConverter("Categorie", class="APIRestLicorneBundle:Categorie")
     */
    public function getAction(Categorie $categorie)
    {
        return array('categorie' => $categorie);
    }

    /**
     *
     */
    public function postAction(Categorie $categorie)
    {

    }

    /**
     *
     */
    public function editAction(Categorie $categorie)
    {

    }
}
