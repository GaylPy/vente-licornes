<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\TypeStock", cascade={"persist"})
     */
    private $typeStock;

    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Categorie", cascade={"persist"})
     * @Expose
     */
    private $categorie;

    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\File")
     */
    private $file;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45)
     */
    private $nom;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set typeStock
     *
     * @param \APIRestLicorneBundle\Entity\TypeStock $typeStock
     *
     * @return Produit
     */
    public function setTypeStock(\APIRestLicorneBundle\Entity\TypeStock $typeStock = null)
    {
        $this->typeStock = $typeStock;

        return $this;
    }

    /**
     * Get typeStock
     *
     * @return \APIRestLicorneBundle\Entity\TypeStock
     */
    public function getTypeStock()
    {
        return $this->typeStock;
    }

    /**
     * Set categorie
     *
     * @param \APIRestLicorneBundle\Entity\Categorie $categorie
     *
     * @return Produit
     */
    public function setCategorie(\APIRestLicorneBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \APIRestLicorneBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set file
     *
     * @param \APIRestLicorneBundle\Entity\File $file
     *
     * @return Produit
     */
    public function setFile(\APIRestLicorneBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \APIRestLicorneBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }
}
