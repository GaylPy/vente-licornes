<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\LigneVente;
use APIRestLicorneBundle\Entity\Vente;
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


class VenteController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *     section="Ventes",
     *     resource=true,
     *     description="Get the list of all ventes.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getVentesAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Vente')->findAll();
    }

    /**
     * @ApiDoc(
     *     section="Ventes",
     *     resource=true,
     *     description="Get one vente.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The vente unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getVenteAction(Vente $vente)
    {
        return $vente;
    }

    /**
     *
     * @ApiDoc(
     *      section="Ventes",
     *      description="Creates a new vente.",
     *      statusCodes={
     *          201="Returned if categorie has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postVentesAction(Request $request)
    {
        $response = new Response();

        $content = $request->getContent();
        if (!empty($content))
        {
            $params = array();
            $params = json_decode($content, true); // 2nd param to get as array

            if(empty($params['vente']) || empty($params['ecurie']) || empty($params['client'])){
                $response->setStatusCode('400');

                return $response;
            }

            $ecurie = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Ecurie')->find($params['ecurie']);
            $client = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Client')->find($params['client']);
            $venteObj = new Vente();
            $venteObj->setEcurie($ecurie);
            $venteObj->setClient($client);
            $venteObj->setDateAchat(new \DateTime());

            $this->getDoctrine()->getManager()->persist($venteObj);

            foreach ($params['vente'] as $vente) {
                $ligneVente = new LigneVente();
                $produit = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Produit')->find($vente['produit']);

                $ligneVente->setProduit($produit);
                $ligneVente->setQuantite($vente['quantite']);
                $ligneVente->setPrixUnitaire('500');
                $ligneVente->setVente($venteObj);

                $this->getDoctrine()->getManager()->persist($ligneVente);
                $this->getDoctrine()->getManager()->flush();
            }

            return $venteObj;
        }
        else{
            $response->setStatusCode('400');
        }

        return $response;
    }

    /**
     * @ApiDoc(
     *      section="Ventes",
     *      description="Delete an existing vente.",
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
     *              "description"="The vente unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteVenteAction(Vente $vente)
    {
        $this->getDoctrine()->getManager()->remove($vente);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }
}
