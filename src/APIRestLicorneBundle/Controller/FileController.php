<?php

namespace APIRestLicorneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FileController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
