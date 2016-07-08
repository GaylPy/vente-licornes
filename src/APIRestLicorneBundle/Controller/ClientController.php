<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Client;
use APIRestLicorneBundle\Form\ClientType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ClientController extends FOSRestController
{

    /**
     *
     * @ApiDoc(
     *     section="Clients",
     *     resource=true,
     *     description="Get the list of all clients.",
     *     statusCodes={
     *          200="Returned when successful",
     *     }
     * )
     */
    public function getClientsAction()
    {
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Client')->findAll();
    }

    /**
     * @ApiDoc(
     *     section="Clients",
     *     resource=true,
     *     description="Get one client.",
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The client unique identifier."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getClientAction(Client $client)
    {
        return $client;
    }

    /**
     * @ParamConverter("client", converter="fos_rest.request_body")
     *
     * @ApiDoc(
     *      section="Clients",
     *      description="Creates a new client.",
     *      statusCodes={
     *          201="Returned if product has been successfully created",
     *          400="Returned if errors",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postClientsAction(Client $client, ConstraintViolationListInterface $violations)
    {
        if (count($violations)) {
            return $this->view($violations, 400);
        }

        $this->getDoctrine()->getManager()->persist($client);
        $this->getDoctrine()->getManager()->flush();

        return $client;
    }

    /**
     * @ApiDoc(
     *      section="Clients",
     *      description="Delete an existing client.",
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
     *              "description"="The client unique identifier."
     *          }
     *      },
     * )
     */
    public function deleteClientAction(Client $client)
    {
        $this->getDoctrine()->getManager()->remove($client);
        $this->getDoctrine()->getManager()->flush();

        return $this->view('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @ApiDoc(
     *     section="Clients",
     *     resource=true,
     *     description="Get one client by email.",
     *     requirements={
     *          {
     *              "name"="email",
     *              "dataType"="string",
     *              "description"="The client email."
     *          }
     *      },
     *      statusCodes={
     *          200="Returned when successful",
     *      }
     * )
     *
     */
    public function getClientByEmailAction($email){
        return $this->getDoctrine()->getRepository('APIRestLicorneBundle:Client')->findOneBy(array(
            'email' => $email
        ));
    }

    /**
     * Connexion un client
     *
     * @View(statusCode=200)
     * @param Request $request
     * @return Response
     * @Method({"POST"})
     *
     * @ApiDoc(
     *     section="Clients",
     *     resource=true,
     *     description="Connect client.",
     *      statusCodes={
     *          200="Returned when successful",
     *          400="Returned if client doesn't exist",
     *          405="Returned if method not allowed",
     *          500="Returned if server error"
     *      }
     * )
     */
    public function postConnexionClientAction(Request $request)
    {
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');

        if($request->getMethod() == 'POST') {
            $obj = json_decode($request->getContent());

            if(empty($obj)){
                $response->setStatusCode(500);
            }
            else {
                $em = $this->getDoctrine()->getManager();
                $client = $em->getRepository('APIRestLicorneBundle:Client')->findOneBy(array(
                    'email' => $obj->{'email'},
                    'password' => $obj->{'password'}
                ));
                if(isset($client)){
                    return $client;
                }
                else{
                    $response->setStatusCode(400);
                }
            }
        }
        else{
            $response->setStatusCode(405);
        }
        $response->send();

        return $response;
    }


}