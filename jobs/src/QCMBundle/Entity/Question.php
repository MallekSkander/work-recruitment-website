<?php

namespace QCMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="QCMBundle\Repository\QuestionRepository")
 */
class Question
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string",  nullable=false)
     */
    protected $titre;
    /**
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Reponse", mappedBy="question", cascade={"remove"})
     */
    private $reponses;

    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="QCM", inversedBy="questions")
     * @JoinColumn(name="qcm_id", referencedColumnName="id")
     */
    private $qcm;

    public function __construct() {
        $this->reponses = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getReponses()
    {
        return $this->reponses;
    }

    /**
     * @param ArrayCollection $reponses
     */
    public function setReponses($reponses)
    {
        $this->reponses = $reponses;
    }

    /**
     * @return mixed
     */
    public function getQcm()
    {
        return $this->qcm;
    }

    /**
     * @param mixed $qcm
     */
    public function setQcm($qcm)
    {
        $this->qcm = $qcm;
    }



    /**
     * Add reponse.
     *
     * @param \QCMBundle\Entity\Reponse $reponse
     *
     * @return Question
     */
    public function addReponse(\QCMBundle\Entity\Reponse $reponse)
    {
        $this->reponses[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse.
     *
     * @param \QCMBundle\Entity\Reponse $reponse
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeReponse(\QCMBundle\Entity\Reponse $reponse)
    {
        return $this->reponses->removeElement($reponse);
    }
}
