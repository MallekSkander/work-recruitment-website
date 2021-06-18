<?php

namespace RendezVousBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Appointment
 *
 * @ORM\Table(name="appointment")
 * @ORM\Entity(repositoryClass="RendezVousBundle\Repository\AppointmentRepository")
 */
class Appointment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    public function __construct() {
        $this->category = new ArrayCollection();
    }



    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string",  nullable=false)
     */
    private $titre;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="appointment")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;



    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="condidat")
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="Humanresourcemanagement")
     * @JoinColumn(name="admin_id", referencedColumnName="id")
     */
    private $admin;

    /**
     * Get id
     *
     * @return int
     */


    /**
 * @var \DateTime
 *
 * @ORM\Column(name="hours", type="datetime")
 */
    private $hours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    public function getId()
    {
        return $this->id;
    }



    /**
     * Set hours
     *
     * @param \DateTime $hours
     *
     * @return Appointment
     */
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get hours
     *
     * @return \DateTime
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Appointment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add category
     *
     * @param \RendezVousBundle\Entity\Category $category
     *
     * @return Appointment
     */
    public function addCategory(\RendezVousBundle\Entity\Category $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \RendezVousBundle\Entity\Category $category
     */
    public function removeCategory(\RendezVousBundle\Entity\Category $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set person
     *
     * @param \AppBundle\Entity\User $person
     *
     * @return Appointment
     */
    public function setPerson(\AppBundle\Entity\User $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AppBundle\Entity\User
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set admin
     *
     * @param \AppBundle\Entity\User $admin
     *
     * @return Appointment
     */
    public function setAdmin(\AppBundle\Entity\User $admin = null)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return \AppBundle\Entity\User
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set category
     *
     * @param \RendezVousBundle\Entity\Category $category
     *
     * @return Appointment
     */
    public function setCategory(\RendezVousBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Appointment
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return Appointment
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
