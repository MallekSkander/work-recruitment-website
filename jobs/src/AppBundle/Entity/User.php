<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;
use DateTime;

use Doctrine\Common\Collections\ArrayCollection;
use  Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToMany;
use FOS\UserBundle\Model\User as BaseUser;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 */

class User extends BaseUser implements UserInterface
{



    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_USER'];

    }
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string",  nullable=false)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string",  nullable=false)
     */
    private $prenom;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_naissance", type="date",  nullable=false)
     */
    private $dateDeNaissance;
    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer", nullable=false)
     */
    private $tel;
    /**
     * @var integer
     *
     * @ORM\Column(name="cin", type="integer",  nullable=false)
     */
    private $cin;
    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string",  nullable=true)
     */
    private $adresse;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string",  nullable=false)
     */
    private $sexe;
    /**
     * @var string
     *
     * @ORM\Column(name="cv", type="string",  nullable=true)
     */
    private $cv;


    /**
     * @var string
     *
     * @ORM\Column(name="photo",type="string" , nullable=true)
     */
    private $photo;
    /**
     * @var boolean
     *
     * @ORM\Column(name="permis_de_conduire",type="boolean" , nullable=true)
     */
    private $permisDeConduire;

    /**
     * @var string
     *
     * @ORM\Column(name="likedIn",type="string" , nullable=true)
     */
    private $likedIn;

    /**
     *
     * @OneToMany(targetEntity="JobHistory", mappedBy="user")
     */
    private $jobsHistory;
    /**
     *
     * @OneToMany(targetEntity="Skill", mappedBy="user")
     */
    private $skills;
    /**
     *
     * @OneToMany(targetEntity="Formation", mappedBy="user")
     */
    private $formations;
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="OffreBundle\Entity\Offre", mappedBy="user")
     */
    private $offres;

    // ...
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="RendezVousBundle\Entity\Session", mappedBy="user")
     */
    private $Session;
    // ...

    /**
     * @param string $email
     */
    public function setEmail( $email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCin(): int
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin(int $cin): void
    {
        $this->cin = $cin;
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
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return DateTime
     */
    public function getDateDeNaissance(): DateTime
    {
        return $this->dateDeNaissance;
    }

    /**
     * @param DateTime $dateDeNaissance
     */
    public function setDateDeNaissance(DateTime $dateDeNaissance): void
    {
        $this->dateDeNaissance = $dateDeNaissance;
    }

    /**
     * @return int
     */
    public function getTel(): int
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     */
    public function setTel(int $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getSexe(): string
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getCv(): string
    {
        return $this->cv;
    }

    /**
     * @param string $cv
     */
    public function setCv(string $cv): void
    {
        $this->cv = $cv;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        if($this->photo != null && $this->photo != "" ){
            file_get_contents($this->photo);
            return base64_encode(file_get_contents($this->photo));
        }else{
            return $this->photo;
        }
    }

    /**
     * @param string $photo
     */
    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return bool
     */
    public function isPermisDeConduire(): bool
    {
        return $this->permisDeConduire;
    }

    /**
     * @param bool $permisDeConduire
     */
    public function setPermisDeConduire(bool $permisDeConduire): void
    {
        $this->permisDeConduire = $permisDeConduire;
    }

    /**
     * @return string
     */
    public function getLikedIn(): string
    {
        return $this->likedIn;
    }

    /**
     * @param string $likedIn
     */
    public function setLikedIn(string $likedIn): void
    {
        $this->likedIn = $likedIn;
    }

    /**
     * @return mixed
     */
    public function getJobsHistory()
    {
        return $this->jobsHistory;
    }

    /**
     * @param mixed $jobsHistory
     */
    public function setJobsHistory($jobsHistory): void
    {
        $this->jobsHistory = $jobsHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getFormations(): \Doctrine\Common\Collections\Collection
    {
        return $this->formations;
    }

    /**
     * @param Collection $formations
     */
    public function setFormations(\Doctrine\Common\Collections\Collection $formations): void
    {
        $this->formations = $formations;
    }

    /**
     * @return Collection
     */
    public function getOffres(): \Doctrine\Common\Collections\Collection
    {
        return $this->offres;
    }

    /**
     * @param Collection $offres
     */
    public function setOffres(\Doctrine\Common\Collections\Collection $offres): void
    {
        $this->offres = $offres;
    }

    /**
     * @return ArrayCollection
     */
    public function getSkills(): \Doctrine\Common\Collections\Collection
    {
        return $this->skills;
    }

    /**
     * @param Collection $skills
     */
    public function setSkills(\Doctrine\Common\Collections\Collection $skills): void
    {
        $this->skills = $skills;
    }
}