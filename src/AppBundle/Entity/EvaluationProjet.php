<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluationProjet
 *
 * @ORM\Table(name="Evaluation_Projet")
 * @ORM\Entity
 */
class EvaluationProjet
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvaluation;

    /**
     * @var string
     *
     * @ORM\Column(name="type_Evaluation", type="string", length=255, nullable=false)
     */
    private $typeEvaluation;


    /**
     * @return string
     */
    public function getTypeEvaluation()
    {
        return $this->typeEvaluation;
    }

    /**
     * @param string $typeEvaluation
     */
    public function setTypeEvaluation($typeEvaluation)
    {
        $this->typeEvaluation = $typeEvaluation;
    }

    /**
     * @return Projet
     */
    public function getIdEvaluation()
    {
        return $this->idEvaluation;
    }

    /**
     * @param Projet $idEvaluation
     */
    public function setIdEvaluation($idEvaluation)
    {
        $this->idEvaluation = $idEvaluation;
    }



}

