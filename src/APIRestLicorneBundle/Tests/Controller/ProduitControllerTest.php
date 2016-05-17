<?php

namespace APIRestLicorneBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProduitControllerTest extends WebTestCase
{
    public function testGetproduits()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProduits');
    }

    public function testGetproduit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProduit');
    }

    public function testPostproduit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/produits');
    }

}
