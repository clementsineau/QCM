<?php

namespace QcmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="question")
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $question;

    /**
     * @ORM\Column(type="string")
     */
    private $reponse; //Réponse à la question

    /**
     * @ORM\Column(type="array")
     */
    private $propositions; //Array de string avec toutes les propositions

    /**
     *
     * @ORM\ManyToOne(targetEntity="QcmBundle\Entity\Qcm",cascade={"persist", "remove", "merge"})
     */
    private $qcm;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param mixed $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }

    /**
     * @return mixed
     */
    public function getPropositions()
    {
        return $this->propositions;
    }

    /**
     * @param mixed $propositions
     */
    public function setPropositions($propositions)
    {
        $this->propositions = $propositions;
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

}