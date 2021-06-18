<?php

namespace RendezVousBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="RendezVousBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Appointment", mappedBy="category", cascade={"remove"})
     */
    private $appointment;



    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->appointment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add appointment
     *
     * @param \RendezVousBundle\Entity\Appointment $appointment
     *
     * @return Category
     */
    public function addAppointment(\RendezVousBundle\Entity\Appointment $appointment)
    {
        $this->appointment[] = $appointment;

        return $this;
    }

    /**
     * Remove appointment
     *
     * @param \RendezVousBundle\Entity\Appointment $appointment
     */
    public function removeAppointment(\RendezVousBundle\Entity\Appointment $appointment)
    {
        $this->appointment->removeElement($appointment);
    }

    /**
     * Get appointment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppointment()
    {
        return $this->appointment;
    }
    public function __toString()
    {
        //return (string)$this->getRate();
        return (string)$this->getName();
    }
}
