<?php

namespace APIRestLicorneBundle\Controller;

use APIRestLicorneBundle\Entity\Client;
use APIRestLicorneBundle\Form\ClientType;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ClientController extends Controller
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

        return array('clients' => $clients);
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
     * Create a Post entity.
     *
     * @View(statusCode=201)
     * @param Request $request
     * @return Response
     *
    */
    public function postClientAction(Request $request)
    {
        $entity = new Client();
        $form = $this->createForm(ClientType::class, $entity, array("method" => $request->getMethod()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        }

        return View::create(array('errors' => $form->getErrors()), Codes::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Delete a client
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
     * Delete a client
     * @param Client $client
     * @return array
     * @View()
     * @ParamConverter("client", class="APIRestLicorneBundle:Client")
     * @Method({"PUT"})
     */
    public function putClientAction(Request $request, Client $client)
    {

    }

    /**
     * @Route("/")
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