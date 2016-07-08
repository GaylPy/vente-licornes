<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prix
 *
 * @ORM\Table(name="prix")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\PrixRepository")
 */
class Prix
{
    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Produit", cascade={"persist"})
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Ecurie", cascade={"persist"})
     */
    private $ecurie;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;


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
     * Set prix
     *
     * @param float $prix
     *
     * @return Prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set produit
     *
     * @param \APIRestLicorneBundle\Entity\Produit $produit
     *
     * @return Prix
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

    /**
     * Set ecurie
     *
     * @param \APIRestLicorneBundle\Entity\Ecurie $ecurie
     *
     * @return Prix
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
}
