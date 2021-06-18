<?php

namespace QCMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="QCMBundle\Repository\ReponseRepository")
 */
class Reponse
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
     * @ORM\Column(name="reponse", type="string",  nullable=false)
     */
    private $reponse;
    /**
     * @var string
     *
     * @ORM\Column(name="correcte", type="boolean",  nullable=false)
     */
    private $correcte;
    /**
     * Many features have one product. This is the owning side.
     * @ManyToOne(targetEntity="Question", inversedBy="reponses")
     * @JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
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
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }

    /**
     * @return string
     */
    public function getCorrecte()
    {
        return $this->correcte;
    }

    /**
     * @param string $correcte
     */
    public function setCorrecte($correcte)
    {
        $this->correcte = $correcte;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }



}

