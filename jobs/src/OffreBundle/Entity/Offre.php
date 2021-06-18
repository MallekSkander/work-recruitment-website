<?php

namespace OffreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="OffreBundle\Repository\OffreRepository")
 */
class Offre
{
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
     * @ORM\Column(name="titre", type="string",  nullable=false)
     */
    private $titre;
    // ...
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="RendezVousBundle\Entity\Session", mappedBy="offre")
     */
    private $Session;
    // ...
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string",  nullable=false)
     */
    private $description;
    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float",  nullable=true)
     */
    private $salaire;
    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean",  nullable=false)
     */
    private $status;
    /**
     * @var string
     *
     * @ORM\Column(name="contrat_type", type="string",  nullable=false)
     */
    private $contrat_type;
    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string",  nullable=false)
     */
    private $adresse;
    /**
     * @var string
     *
     * @ORM\Column(name="nb_annee_experience", type="integer",  nullable=false)
     */
    private $nbAnneeExperience;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime",  nullable=false)
     */
    private $datePublication;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime",  nullable=false)
     */
    private $dateModification;

    /**
     * @return \DateTime
     */
    public function getDatePublication(): \DateTime
    {
        return $this->datePublication;
    }

    /**
     * @param \DateTime $datePublication
     */
    public function setDatePublication(\DateTime $datePublication): void
    {
        $this->datePublication = $datePublication;
    }

    /**
     * @return \DateTime
     */
    public function getDateModification(): \DateTime
    {
        return $this->dateModification;
    }

    /**
     * @param \DateTime $dateModification
     */
    public function setDateModification(\DateTime $dateModification): void
    {
        $this->dateModification = $dateModification;
    }
    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="offres")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     *
     * @OneToMany(targetEntity="Tag", mappedBy="offre")
     */
    private $tags;

    public function __construct() {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
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
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * @param string $salaire
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getContratType(): string
    {
        return $this->contrat_type;
    }

    /**
     * @param string $contrat_type
     */
    public function setContratType(string $contrat_type): void
    {
        $this->contrat_type = $contrat_type;
    }

    /**
     * @return string
     */
    public function getNbAnneeExperience(): string
    {
        return $this->nbAnneeExperience;
    }

    /**
     * @param string $nbAnneeExperience
     */
    public function setNbAnneeExperience(string $nbAnneeExperience): void
    {
        $this->nbAnneeExperience = $nbAnneeExperience;
    }

}

