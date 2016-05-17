<?php

namespace APIRestLicorneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="APIRestLicorneBundle\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Adresse", cascade={"persist"})
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity="APIRestLicorneBundle\Entity\Fidelite", cascade={"persist"})
     */
    private $fidelite;

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
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="datetime")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;

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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Client
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Client
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Client
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return Employe
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Employe
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set adresse
     *
     * @param \APIRestLicorneBundle\Entity\Adresse $adresse
     *
     * @return Client
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

    /**
     * Set fidelite
     *
     * @param \APIRestLicorneBundle\Entity\Fidelite $fidelite
     *
     * @return Client
     */
    public function setFidelite(\APIRestLicorneBundle\Entity\Fidelite $fidelite = null)
    {
        $this->fidelite = $fidelite;

        return $this;
    }

    /**
     * Get fidelite
     *
     * @return \APIRestLicorneBundle\Entity\Fidelite
     */
    public function getFidelite()
    {
        return $this->fidelite;
    }
}
