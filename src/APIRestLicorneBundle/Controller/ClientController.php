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
        return array('client' => $client);
    }

    /**
     * Créer un client
     *
     * @View(statusCode=201)
     * @param Request $request
     * @return Response
     *
    */
    public function postClientAction(Request $request)
    {
        var_dump($request->request);
        die();
        $entity = new Client();
        $form = $this->createForm(ClientType::class, $entity, array("method" => $request->getMethod()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->handleView($this->view(array('client' => $entity), 200));
        }

        return $this->handleView($this->view(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR));
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