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
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Produit", cascade={"persist"})
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
     * @ORM\Column(name="prixHT", type="float")
     */
    private $prixHT;


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
     * Set prixHT
     *
     * @param float $prixHT
     *
     * @return Prix
     */
    public function setPrixHT($prixHT)
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    /**
     * Get prixHT
     *
     * @return float
     */
    public function getPrixHT()
    {
        return $this->prixHT;
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
