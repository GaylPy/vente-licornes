<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Adresse
 *
 * @ORM\Table(name="adresse")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\AdresseRepository")
 */
class Adresse
{
    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Pays", cascade={"persist"})
     */
    private $pays;

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
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    public function __toString()
    {
        return $this->getVille();
    }

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
     * Set ville
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param \APIRestLicorneBundle\Entity\Pays $pays
     *
     * @return Adresse
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
     * @VirtualProperty
     */
    public function getPays()
    {
        return $this->pays;
    }
}
