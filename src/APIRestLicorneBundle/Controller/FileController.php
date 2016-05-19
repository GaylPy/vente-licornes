<?php

namespace APIRestLicorneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use APIRestLicorneBundle\Entity\File;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @RouteResource("File")
 * */

class FileController extends FOSRestController
{
    /**
     * @return array
     * @View()
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $files = $em->getRepository('APIRestLicorneBundle:File')->findAll();

        $view = $this->view(array('files' => $files), 200);

        return $this->handleView($view);
    }

    /**
     * @param File $file
     * @return array
     * @View()
     * @ParamConverter("File", class="APIRestLicorneBundle:File")
     */
    public function getAction(File $file)
    {
        return array('file' => $file);
    }

    /**
     *
     */
    public function postAction(File $file)
    {

    }

    /**
     *
     */
    public function editAction(File $file)
    {

    }

    public function deleteAction(File $file)
    {

    }   
}
