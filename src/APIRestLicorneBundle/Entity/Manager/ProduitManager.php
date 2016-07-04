<?php

namespace APIRestLicorneBundle\Entity\Manager;

use APIRestLicorneBundle\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;

class ProduitManager
{
    public function __construct(ObjectManager $em) {
        $this->em = $em;
    }

    public function save(Produit $produit)
    {
        $this->em->persist($produit);
        $this->em->flush();
    }

    public function remove(Produit $produit)
    {
        $this->em->remove($produit);
        $this->em->flush();
    }
}