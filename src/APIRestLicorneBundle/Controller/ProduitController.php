<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Produit;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProduitController extends Controller
{
    /**
     * @return array
     * @View()
     */
    public function getProduitsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('APIRestLicorneBundle:Produit')->findAll();

        return array('produits' => $produits);
    }

    /**
     * @param Produit $produit
     * @return array
     * @View()
     * @ParamConverter("Client", class="APIRestLicorneBundle:Produit")
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

    

}
