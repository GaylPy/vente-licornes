<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Produit;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProduitController extends FOSRestController
{
    /**
     * @return array
     * @View()
     */
    public function getProduitsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('APIRestLicorneBundle:Produit')->findAll();

        $view = $this->view(array('produits' => $produits), 200);

        return $this->handleView($view);
    }

    /**
     * @param Produit $produit
     * @return array
     * @View()
     * @ParamConverter("Produit", class="APIRestLicorneBundle:Produit")
     */
    public function getProduitAction(Produit $produit)
    {
        return array('produit' => $produit);
    }

    /**
     *
     */
    public function postProduitAction(Produit $produit)
    {

    }

    /**
     *
     */
    public function editProduitAction(Produit $produit)
    {

    }

    public function deleteProduitAction(Produit $produit)
    {
 
    }


}
