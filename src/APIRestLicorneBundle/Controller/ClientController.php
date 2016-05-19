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

class ClientController extends FOSRestController
{
    /**
     * Renvoi la liste complète des clients
     *
     * @return array
     * @View()
     */
    public function getClientsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('APIRestLicorneBundle:Client')->findAll();

        $view = $this->view(array('clients' => $clients), 200);

        return $this->handleView($view);
    }

    /**
     * Renvoi un client
     *
     * @param Client $client
     * @return array
     * @View()
     * @ParamConverter("client", class="APIRestLicorneBundle:Client")
     */
    public function getClientAction(Client $client)
    {
        $view = $this->view(array('client' => $client), 200);
        return $this->handleView($view);
    }

    /**
     * Créer un client
     *
     * @View(statusCode=200)
     * @param Request $request
     * @return Response
     *
    */
    public function postClientAction(Request $request)
    {
        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', 'http://unicorn');

        $content = 'Vide';

        if($request->getMethod() == 'POST') {
            $obj = json_decode($request->getContent());

            $entity = new Client();

            if(empty($obj)){
                $error = array('message' => 'Erreur interne.');
                $content = json_encode($error);
            }
            else{
                if(isset($obj->{'firstname'}) && isset($obj->{'name'}) && isset($obj->{'email'}) && isset($obj->{'password'})){

                    $entity->setPrenom($obj->{'firstname'});
                    $entity->setNom($obj->{'name'});
                    $entity->setEmail($obj->{'email'});
                    $entity->setPassword($obj->{'password'});
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();

                    $success = array('message' => 'ok');
                    $content = json_encode($success);

                }
                else{
                    $error = array('message' => 'Veuillez renseigner tous les champs.');
                    $content = json_encode($error);
                }
            }
        }
        else{
            $error = array('message' => 'Erreur interne');
            $content = json_encode($error);
        }


        // prints the HTTP headers followed by the content
        $response->setContent($content);
        $response->send();

    }

    /**
     * Connexion un client
     *
     * @View(statusCode=200)
     * @param Request $request
     * @return Response
     * @Method({"POST"})
     */
    public function postConnexionClientAction(Request $request)
    {

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', 'http://unicorn');

        $content = 'Vide';

        if($request->getMethod() == 'POST') {
            $obj = json_decode($request->getContent());
            if(empty($obj)){
                $error = array('message' => 'Erreur interne.');
                $content = json_encode($error);
            }
            else {
                $em = $this->getDoctrine()->getManager();
                $client = $em->getRepository('APIRestLicorneBundle:Client')->findOneBy(array(
                    'email' => $obj->{'email'},
                    'password' => $obj->{'password'}
                ));

                if(isset($client)){
                    $success = array('message' => 'ok');
                    $content = json_encode($success);
                }
                else{
                    $error = array('message' => 'ko');
                    $content = json_encode($error);
                }
            }
        }
        else{
            $error = array('message' => 'Erreur interne');
            $content = json_encode($error);
        }


        // prints the HTTP headers followed by the content
        $response->setContent($content);
        $response->send();
    }

    /**
     * Modifier un client
     *
     * @param Client $client
     * @return array
     * @View()
     * @ParamConverter("client", class="APIRestLicorneBundle:Client")
     * @Method({"PUT"})
     */
    public function putClientAction(Request $request, Client $client)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($client);
            $em->flush();

            return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Supprimer un client
     *
     * @param Client $client
     * @return array
     * @View()
     * @ParamConverter("client", class="APIRestLicorneBundle:Client")
     * @Method({"DELETE"})
     */
    public function deleteClientAction(Client $client)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($client);
        $em->flush();

        $clients = $em->getRepository('APIRestLicorneBundle:Client')->findAll();

        return array('clients' => $clients);
    }

    /**
     * @Route("/client/create")
     *
     */
    public function createFormClientAction(){
        $entity = new Client();
        $form = $this->createForm(ClientType::class, $entity);

        return $this->render('APIRestLicorneBundle:Default:index.html.twig', array(
           'form' => $form->createView()
        ));
    }
}