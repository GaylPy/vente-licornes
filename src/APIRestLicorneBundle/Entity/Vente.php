<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vente
 *
 * @ORM\Table(name="vente")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\VenteRepository")
 */
class Vente
{
    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Client")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Ecurie")
     */
    private $ecurie;

    /**
     * @ORM\ManyToOne(targetEntity="APIRestLicorneBundle\Entity\Promo")
     */
    private $promo;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAchat", type="datetimetz")
     */
    private $dateAchat;


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
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     *
     * @return Vente
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set client
     *
     * @param \APIRestLicorneBundle\Entity\Client $client
     *
     * @return Vente
     */
    public function setClient(\APIRestLicorneBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \APIRestLicorneBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set ecurie
     *
     * @param \APIRestLicorneBundle\Entity\Ecurie $ecurie
     *
     * @return Vente
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
     * Set promo
     *
     * @param \APIRestLicorneBundle\Entity\Promo $promo
     *
     * @return Vente
     */
    public function setPromo(\APIRestLicorneBundle\Entity\Promo $promo = null)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return \APIRestLicorneBundle\Entity\Promo
     */
    public function getPromo()
    {
        return $this->promo;
    }
}
