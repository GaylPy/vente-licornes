<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Ecurie;
use APIRestLicorneBundle\Entity\Prix;
use APIRestLicorneBundle\Entity\Produit;
use APIRestLicorneBundle\Entity\Stock;
use APIRestLicorneBundle\Form\ProduitType;
use FOS\RestBundle\Controller\Annotations\RequestParam;
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
// Get Route Definition
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;


class ProduitController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *     section="Produits",
     *     resource=true,
     *     description="Recup�re la liste de tous les produits.",
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
     *     description="R�cup�re un produit.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="ID du produit."
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
     */
    /**
     *
     * @ApiDoc(
     *      section="Produits",
     *      description="Creates a new product",
     *      requirements={
     *          {
     *              "name"="nom",
     *              "dataType"="string",
     *              "requirement"="requis",
     *              "description"="Nom du produit"
     *          },
     *          {
     *              "name"="categorie",
     *              "dataType"="integer",
     *              "requirement"="non requi",
     *              "description"="Id de la categorie du produit"
     *          },
     *          {
     *              "name"="ecurie",
     *              "dataType"="integer",
     *              "requirement"="non requis",
     *              "description"="Id de l'ecurie du produit"
     *          },
     *          {
     *              "name"="prix",
     *              "dataType"="float",
     *              "requirement"="non requi",
     *              "description"="prix du produit"
     *          },
     *          {
     *              "name"="quantite",
     *              "dataType"="integer",
     *              "requirement"="non requi",
     *              "description"="Quantite de produit"
     *          }
     *      },
     *      statusCodes={
     *          201="Returned if product has been successfully created",
     *          400="Bad Request : La syntaxe de la requ�te est erron�e.",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postProduitsAction(Request $request)
    {
        $response = new Response();

        $content = $request->getContent();
        if (!empty($content))
        {
            $params = array();
            $params = json_decode($content, true); // 2nd param to get as array

            if(empty($params['nom'])){
                $response->setStatusCode('400');
            }
            else{
                $nom = $params['nom'];

                $produit = new Produit();
                $produit->setNom($nom);

                // Cat�gorie

                if(isset($params['categorie'])){
                    $cat = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Categorie')->find($params['categorie']);

                    if($cat){
                        $produit->setCategorie($cat);
                    }
                }

                // AJout du prix
                if(isset($params['ecurie']) && isset($params['prix'])){
                    $ecurie = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Ecurie')->find($params['ecurie']);

                    if($ecurie){
                        $prix = new Prix();
                        $prix->setEcurie($ecurie);
                        $prix->setPrix($params['prix']);
                        $prix->setProduit($produit);
                        $this->getDoctrine()->getManager()->persist($prix);

                        if(isset($params['quantite'])){
                            $stock = new Stock();
                            $stock->setEcurie($ecurie);
                            $stock->setProduit($produit);
                            $stock->setQuantite($params['quantite']);

                            $this->getDoctrine()->getManager()->persist($stock);
                        }
                    }
                }


                $this->getDoctrine()->getManager()->persist($produit);
                $this->getDoctrine()->getManager()->flush();
                $response->setStatusCode('201');
            }
        }
        else{
            $response->setStatusCode('400');
        }

        return $response;

        /*
        $entity = new Produit();
        $form = $this->createForm(ProduitType::class, $entity, array("method" => $request->getMethod()));
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $entity;
        }
        else{
            var_dump($form);die();
        }
        return $this->handleView($this->view(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR));
    */
    }

    /**
     *
     * Use the "locale" parameter as the default value
     * @QueryParam(name="produit", default="\d+")
     *
     * The "baz" container parameter is used here as requirements
     * Can be used for complex or auto-generated regex
     * @QueryParam(name="ecurie", requirements="\d+")
     *
     *
     * @ApiDoc(
     *      section="Produits",
     *      description="Delete an existing product. /api/produits?produit={id}&ecurite={id}",
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
     *          },
     *          {
     *              "name"="idecurie",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The ecurie unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteProduitsAction(ParamFetcher $paramFetcher)
    {
        /*
        $prix = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findOneBy(array(
            'produit' => $produit,
            'ecurie' => $ecurie
        ));
        $this->getDoctrine()->getManager()->remove($prix);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
*/
        // ParamFetcher params can be dynamically added during runtime instead of only compile time annotations.
        $dynamicRequestParam = new RequestParam();
        $dynamicRequestParam->name = "dynamic_request";
        $dynamicRequestParam->requirements = "\d+";
        $paramFetcher->addParam($dynamicRequestParam);

        $dynamicQueryParam = new QueryParam();
        $dynamicQueryParam->name = "dynamic_query";
        $dynamicQueryParam->requirements="[a-z]+";
        $paramFetcher->addParam($dynamicQueryParam);

        $produit = $paramFetcher->get('produit');
        $ecurie = $paramFetcher->get('ecurie');

        $prix = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findOneBy(array(
            'produit' => $produit,
            'ecurie' => $ecurie
        ));

        $stock = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Stock')->findOneBy(array(
            'produit' => $produit,
            'ecurie' => $ecurie
        ));

        if(!$prix || !$stock){
            $response = new Response();
            $response->setStatusCode('400');

            return $response;
        }

        $this->getDoctrine()->getManager()->remove($stock);
        $this->getDoctrine()->getManager()->remove($prix);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }

    /**
     *
     * @ApiDoc(
     *     section="Produits",
     *     resource=true,
     *     description="Recupere la liste de tous les produits d'une ecurie avec les prix.",
     *     statusCodes={
     *          200="Returned when successful",
     *     },
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="L'identifiant de l'ecurie (1 pour ecurie de Lille)."
     *          }
     *      },
     * )
     *
    */
    public function getProduitsEcurieAction($id)
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findBy(array(
            'ecurie' => $id
        ));
    }



}
