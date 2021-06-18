<?php

namespace QCMBundle\Entity;
use Doctrine\Common\Collections\Collection;
use OffreBundle\Entity\Offre;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;

/**
 * QCM
 *
 * @ORM\Table(name="q_c_m")
 * @ORM\Entity(repositoryClass="QCMBundle\Repository\QCMRepository")
 */
class QCM
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
     * @OneToMany(targetEntity="Question", mappedBy="qcm")
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="OffreBundle\Entity\Offre", inversedBy="QCM")
     * @ORM\JoinColumn(name="offre_id", referencedColumnName="id")
     */
    private $offre;

    public function __construct() {
        $this->questions = new ArrayCollection();
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
     * @return Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Collection $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }

    /**
     * @return mixed
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * @param mixed $offre
     */
    public function setOffre($offre)
    {
        $this->offre = $offre;
    }



    /**
     * Add question
     *
     * @param \QCMBundle\Entity\Question $question
     *
     * @return QCM
     */
    public function addQuestion(\QCMBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \QCMBundle\Entity\Question $question
     */
    public function removeQuestion(\QCMBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }


}
