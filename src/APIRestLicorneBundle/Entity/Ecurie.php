<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ecurie
 *
 * @ORM\Table(name="ecurie")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\EcurieRepository")
 */
class Ecurie
{
    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Adresse", cascade={"persist"})
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


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
     * Set adresse
     *
     * @param \APIRestLicorneBundle\Entity\Adresse $adresse
     *
     * @return Ecurie
     */
    public function setAdresse(\APIRestLicorneBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \APIRestLicorneBundle\Entity\Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
}
