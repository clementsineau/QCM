<?php

namespace QcmBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="qcm")
 */
class Qcm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $titre; //Titre du QCM


    /**
     *
     * @ORM\OneToMany(targetEntity="QcmBundle\Entity\Question",mappedBy="id",cascade={"persist", "remove", "merge"}) )
     */
    private $questions; //Array contenant les questions

    /**
     *
     * @ORM\OneToMany(targetEntity="QcmBundle\Entity\Resultat",mappedBy="id", cascade={"persist", "remove", "merge"}) )
     */
    private $resultats;

    /**
     * @return mixed
     */
    public function getResultats()
    {
        return $this->resultats;
    }

    /**
     * @param mixed $resultats
     */
    public function setResultats($resultats)
    {
        $this->resultats = $resultats;
    } //Array contenant les resultats

    public function __construct() {
        $this->resultats = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return mixed
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param mixed $questions
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
    }


}