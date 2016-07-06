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
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class CategorieController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *     section="Categories",
     *     resource=true,
     *     description="Get the list of all categories.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getCategoriesAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Categorie')->findAll();
    }

    /**
     * @ApiDoc(
     *     section="Categories",
     *     resource=true,
     *     description="Get one category.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The category unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getCategorieAction(Categorie $categorie)
    {
        return $categorie;
    }

    /**
     * @ParamConverter("categorie", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *      section="Categories",
     *      description="Creates a new categorie.",
     *      statusCodes={
     *          201="Returned if categorie has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postCategorieAction(Categorie $categorie, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $this->getDoctrine()->getManager()->persist($categorie);
        $this->getDoctrine()->getManager()->flush();

        return $this->view(null, 201,
            [
                'Location' => $this->generateUrl('get_categorie', [ 'categorie' => $categorie->getId()]),
            ]);
    }

    /**
     * @ApiDoc(
     *      section="Categories",
     *      description="Delete an existing categorie.",
     *      statusCodes={
     *          201="Returned if categorie has been successfully deleted",
     *          400="Returned if categorie does not exist",
     *          500="Returned if server error"
     *      },
     *      requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The categorie unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteCategorieAction(Categorie $categorie)
    {
        $this->getDoctrine()->getManager()->remove($categorie);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }
}
