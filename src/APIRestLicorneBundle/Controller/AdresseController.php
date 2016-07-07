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
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class AdresseController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *     section="Adresse",
     *     resource=true,
     *     description="Get the list of all Adresse.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getAdressesAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Adresse')->findAll();
    }

    /**
     * @ApiDoc(
     *     section="Adresse",
     *     resource=true,
     *     description="Get one Adresse.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The Adresse unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getAdresseAction(Adresse $adresse)
    {
        return $adresse;
    }

    /**
     * @ParamConverter("adresse", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *      section="Adresse",
     *      description="Creates a new Adresse.",
     *      statusCodes={
     *          201="Returned if product has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postAdresseAction(Adresse $adresse, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $this->getDoctrine()->getManager()->persist($adresse);
        $this->getDoctrine()->getManager()->flush();

        return $this->view(null, 201,
            [
                'Location' => $this->generateUrl('get_adresse', [ 'adresse' => $adresse->getId()]),
            ]);
    }

    /**
     * @ApiDoc(
     *      section="Adresse",
     *      description="Delete an existing Adresse.",
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
     *              "description"="The Adresse unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteAdresseAction(Adresse $adresse)
    {
        $this->getDoctrine()->getManager()->remove($adresse);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }
}