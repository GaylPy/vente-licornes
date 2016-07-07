<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Pays;
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

class PaysController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *     section="Country",
     *     resource=true,
     *     description="Get the list of all Country.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getCountriesAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Pays')->findAll();
    }

    /**
     * @ApiDoc(
     *     section="Country",
     *     resource=true,
     *     description="Get one country.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The Country unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getCountryAction(Pays $pays)
    {
        return $pays;
    }

    /**
     * @ParamConverter("pays", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *      section="Country",
     *      description="Creates a new Country.",
     *      statusCodes={
     *          201="Returned if product has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postCountryAction(Pays $pays, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $this->getDoctrine()->getManager()->persist($pays);
        $this->getDoctrine()->getManager()->flush();

        return $this->view(null, 201,
            [
                'Location' => $this->generateUrl('get_country', [ 'pays' => $pays->getId()]),
            ]);
    }

    /**
     * @ApiDoc(
     *      section="Country",
     *      description="Delete an existing Country.",
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
     *              "description"="The Country unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteCountryAction(Pays $pays)
    {
        $this->getDoctrine()->getManager()->remove($pays);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }
}
