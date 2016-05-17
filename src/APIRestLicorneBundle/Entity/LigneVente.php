<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneVente
 *
 * @ORM\Table(name="ligne_vente")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\LigneVenteRepository")
 */
class LigneVente
{
    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Vente", cascade={"persist"})
     */
    private $vente;

    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Produit")
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
     * @var float
     *
     * @ORM\Column(name="prixUnitaire", type="float")
     */
    private $prixUnitaire;


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
     * @return LigneVente
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
     * Set prixUnitaire
     *
     * @param float $prixUnitaire
     *
     * @return LigneVente
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return float
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set vente
     *
     * @param \APIRestLicorneBundle\Entity\Vente $vente
     *
     * @return LigneVente
     */
    public function setVente(\APIRestLicorneBundle\Entity\Vente $vente = null)
    {
        $this->vente = $vente;

        return $this;
    }

    /**
     * Get vente
     *
     * @return \APIRestLicorneBundle\Entity\Vente
     */
    public function getVente()
    {
        return $this->vente;
    }

    /**
     * Set produit
     *
     * @param \APIRestLicorneBundle\Entity\Produit $produit
     *
     * @return LigneVente
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
