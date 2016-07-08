<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\StockRepository")
 */
class Stock
{
    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Ecurie")
     */
    private $ecurie;

    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Produit", cascade={"persist"})
     */
    private $produit;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Stock
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set ecurie
     *
     * @param \APIRestLicorneBundle\Entity\Ecurie $ecurie
     *
     * @return Stock
     */
    public function setEcurie(\APIRestLicorneBundle\Entity\Ecurie $ecurie = null)
    {
        $this->ecurie = $ecurie;

        return $this;
    }

    /**
     * Get ecurie
     *
     * @return \APIRestLicorneBundle\Entity\Ecurie
     */
    public function getEcurie()
    {
        return $this->ecurie;
    }

    /**
     * Set produit
     *
     * @param \APIRestLicorneBundle\Entity\Produit $produit
     *
     * @return Stock
     */
    public function setProduit(\APIRestLicorneBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \APIRestLicorneBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }
}
