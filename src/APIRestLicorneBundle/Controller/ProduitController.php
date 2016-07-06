<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Produit;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use APIRestLicorneBundle\Entity\Manager\ProduitManager;

class ProduitController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *     section="Produits",
     *     resource=true,
     *     description="Get the list of all categories.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getProduitsAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Produit')->findAll();
    }

    /**
     * @ApiDoc(
     *     section="Produits",
     *     resource=true,
     *     description="Get one product.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The product unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getProduitAction(Produit $produit)
    {
        return $produit;
    }

    /**
     * @ParamConverter("produit", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *      section="Produits",
     *      description="Creates a new product.",
     *      statusCodes={
     *          201="Returned if product has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postProduitsAction(Produit $produit, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $this->getDoctrine()->getManager()->persist($produit);
        $this->getDoctrine()->getManager()->flush();

        return $this->view(null, 201,
            [
                'Location' => $this->generateUrl('get_produit', [ 'produit' => $produit->getId()]),
            ]);
    }

    /**
     * @ApiDoc(
     *      section="Produits",
     *      description="Delete an existing product.",
     *      statusCodes={
     *          201="Returned if product has been successfully deleted",
     *          400="Returned if product does not exist",
     *          500="Returned if server error"
     *      },
     *      requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The product unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteProduitAction(Produit $produit)
    {
        $this->getDoctrine()->getManager()->remove($produit);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }


}
