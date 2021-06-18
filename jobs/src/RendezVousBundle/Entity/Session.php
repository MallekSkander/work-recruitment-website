<?php

namespace RendezVousBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * Session
 *
 * @ORM\Table(name="session")
 * @ORM\Entity(repositoryClass="RendezVousBundle\Repository\SessionRepository")
 */
class Session
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    // ...
    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="Session")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    // ...

    // ...
    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="OffreBundle\Entity\Offre", inversedBy="Session")
     * @JoinColumn(name="offre_id", referencedColumnName="id")
     */
    private $offre;
    // ...



    /**
     * @var float
     *
     * @ORM\Column(name="score", type="float",  nullable=true)
     */
    private $score;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $Date;




    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set score.
     *
     * @param float|null $score
     *
     * @return Session
     */
    public function setScore($score = null)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score.
     *
     * @return float|null
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Session
     */
    public function setDate($date)
    {
        $this->Date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Session
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set offre.
     *
     * @param \OffreBundle\Entity\Offre|null $offre
     *
     * @return Session
     */
    public function setOffre(\OffreBundle\Entity\Offre $offre = null)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre.
     *
     * @return \OffreBundle\Entity\Offre|null
     */
    public function getOffre()
    {
        return $this->offre;
    }
}
