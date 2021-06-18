<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * JobHistory
 *
 * @ORM\Table(name="job_history")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobHistoryRepository")
 */
class JobHistory
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="User", inversedBy="jobsHistory")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date",  nullable=false)
     */
    protected $dateDebut;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date",  nullable=false)
     */
    protected $dateFin;
    /**
     * @var string
     *
     * @ORM\Column(name="travaille", type="string",  nullable=false)
     */
    protected $travaille;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string",  nullable=true)
     */
    protected $description;

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
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut(): \DateTime
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut(\DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin(): \DateTime
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin(\DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string
     */
    public function getTravaille(): string
    {
        return $this->travaille;
    }

    /**
     * @param string $travaille
     */
    public function setTravaille(string $travaille): void
    {
        $this->travaille = $travaille;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }



}

