<?php

namespace APIRestLicorneBundle\Controller;

use Doctrine\DBAL\Types\Type;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use APIRestLicorneBundle\Entity\TypeStock;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @RouteResource("Typestock")
 * */

class TypeStockController extends FOSRestController
{
    /**
     * @return array
     * @View()
     * 
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typestocks = $em->getRepository('APIRestLicorneBundle:TypeStock')->findAll();
        
        $view = $this->view(array('typestocks' => $typestocks), 200);

        return $this->handleView($view);

    }

    /**
     * @param TypeStock $typestock
     * @return array
     * @View()
     * @ParamConverter("TypeStock", class="APIRestLicorneBundle:TypeStock")
     */
    public function getTypeStockAction(TypeStock $typestock)
    {
        return array('typestock' => $typestock);
    }

    /**
     *
     */
    public function postTypeStockAction(TypeStock $typestock)
    {

    }

    /**
     *
     */
    public function editTypeStockAction(TypeStock $typestock)
    {

    }
}
