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
     *     description="Recupere la liste de tous les produits.",
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
     *     description="Recupere un produit.",
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
     *          400="Bad Request : La syntaxe de la requête est erronée.",
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

                // Catégorie

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
    }

    /**
     *
     *
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
     *              "name"="produit",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The product unique identifier."
     *          },
     *          {
     *              "name"="ecurie",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The ecurie unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteProduitsAction(Request $request)
    {
        $response = new Response();

        $content = $request->getContent();

        if (!empty($content)) {
            $params = array();
            $params = json_decode($content, true); // 2nd param to get as array

            if (empty($params['produit']) || empty($params['ecurie'])) {
                $response->setStatusCode('400');
                return $response;
            }
            else {
                $ecurie = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Ecurie')->find($params['ecurie']);
                $produit = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Produit')->find($params['produit']);

                if(!is_object($produit) && !is_object($ecurie)){
                    $response->setStatusCode('404');
                    return $response;
                }

                $prix = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findOneBy(array(
                    'produit' => $produit,
                    'ecurie' => $ecurie
                ));

                $stock = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Stock')->findOneBy(array(
                    'produit' => $produit,
                    'ecurie' => $ecurie
                ));

                if($prix){
                    $this->getDoctrine()->getManager()->remove($prix);
                }

                if($stock){
                    $this->getDoctrine()->getManager()->remove($stock);
                }

                $this->getDoctrine()->getManager()->flush();

                return $this->view('', Response::HTTP_NO_CONTENT);
            }
        }
        else{
            $response = new Response();
            $response->setStatusCode('400');

            return $response;
        }
    }

    /**
     * @ApiDoc(
     *      section="Produits",
     *      resource=true,
     *     description="Modification d'un produit",
     *     statusCodes={
     *          200="Returned when successful",
     *          304="Returned when no modified",
     *
     *     },
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="L'identifiant du produit."
     *          }
     *      },
     * )
     */
    public function putProduitsAction(Request $request){

        $response = new Response();

        $em = $this->getDoctrine()->getManager();

        $content = $request->getContent();

        if (!empty($content)) {
            $params = array();
            $params = json_decode($content, true); // 2nd param to get as array

            if (empty($params['produit']) || empty($params['ecurie'])) {
                $response->setStatusCode('400');
                return $response;
            }
            else{
                $produit = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Produit')->find($params['produit']);
                $ecurie = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Ecurie')->find($params['ecurie']);

                if(!is_object($produit) || !is_object($ecurie)){
                    $response->setStatusCode('400');
                    return $response;
                }

                if(!empty($params['prix'])){
                    $prix = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findPrixProduit($ecurie, $produit);

                    if(is_object($prix)){
                        $prix->setPrix($params['prix']);
                        $em->persist($prix);
                    }
                }

                if(!empty($params['quantite'])){
                    $stock = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Stock')->findOneBy(array(
                        'ecurie' => $ecurie,
                        'produit' => $produit
                    ));

                    if(is_object($stock)){
                        $stock->setQuantite($params['quantite']);
                        $em->persist($stock);
                    }
                }

                $em->flush();

                $response->setStatusCode('200');
                return $response;
            }
        }

        return $this->view(null, Codes::HTTP_NOT_MODIFIED);
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

    /**
     *
     * Use the "locale" parameter as the default value
     * @QueryParam(name="produit", requirements="\d+")
     *
     * @QueryParam(name="ecurie", requirements="\d+")
     *
     *
     * @ApiDoc(
     *      section="Produits",
     *      resource=true,
     *      description="Recupere le prix d'un produit. URL : /api/produits/prix?produit={id}&ecurie=[id}"),
     *      statusCodes={
     *          200="Returned when succesful",
     *          400="Returned Bad Request, error syntax",
     *      },
     * )
     */
    public function getProduitsGetPrixAction(ParamFetcher $paramFetcher){
        $dynamicRequestParam = new RequestParam();
        $dynamicRequestParam->name = "dynamic_request";
        $dynamicRequestParam->requirements = "\d+";
        $paramFetcher->addParam($dynamicRequestParam);

        $dynamicQueryParam = new QueryParam();
        $dynamicQueryParam->name = "dynamic_query";
        $dynamicQueryParam->requirements="[a-z]+";
        $paramFetcher->addParam($dynamicQueryParam);

        if(empty($paramFetcher->get('ecurie')) || empty($paramFetcher->get('produit'))){
            $response = new Response();
            $response->setStatusCode('400');

            return $response;
        }

        $ecurie = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Ecurie')->find($paramFetcher->get('ecurie'));
        $produit = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Produit')->find($paramFetcher->get('produit'));

        if(!is_object($ecurie) || !is_object($produit)){
            $response = new Response();
            $response->setStatusCode('400');

            return $response;
        }

        $prix = $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findPrixProduit($ecurie, $produit);

        return $prix;
    }

    /**
     * @ApiDoc(
     *      section="Produits",
     *      resource=true,
     *      description="Recupere les 3 derniers produits"),
     *      statusCodes={
     *          200="Returned when succesful",
     *      },
     * )
     */
    public function getLastProduitsAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Prix')->findLastProduit();

    }


}
