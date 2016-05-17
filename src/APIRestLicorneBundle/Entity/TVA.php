<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TVA
 *
 * @ORM\Table(name="tva")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\TVARepository")
 */
class TVA
{
    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Pays")
     */
    private $pays;

    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Categorie")
     */
    private $categorie;

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
     * @ORM\Column(name="taux", type="float")
     */
    private $taux;


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
     * Set taux
     *
     * @param float $taux
     *
     * @return TVA
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * Get taux
     *
     * @return float
     */
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * Set pays
     *
     * @param \APIRestLicorneBundle\Entity\Pays $pays
     *
     * @return TVA
     */
    public function setPays(\APIRestLicorneBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \APIRestLicorneBundle\Entity\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set categorie
     *
     * @param \APIRestLicorneBundle\Entity\Categorie $categorie
     *
     * @return TVA
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
}
