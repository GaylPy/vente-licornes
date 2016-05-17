<?php

namespace APIRestLicorneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TypeStockController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
