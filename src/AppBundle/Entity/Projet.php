<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Projet
 *
 * @ORM\Table(name="Projet", uniqueConstraints={@ORM\UniqueConstraint(name="id_helper_Projet_UNIQUE", columns={"id_helper_Projet"}), @ORM\UniqueConstraint(name="id_Evaluation_UNIQUE", columns={"id_Evaluation"}), @ORM\UniqueConstraint(name="id_Entreprise_UNIQUE", columns={"id_Entreprise"})})
 * @ORM\Entity
 */
class Projet
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_Projet", type="string", length=255, nullable=false)
     */
    private $nomProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="salle_Projet", type="string", length=255, nullable=false)
     */
    private $salleProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="projet_Ext_Int_Projet", type="string", length=255, nullable=false)
     */
    private $projetExtIntProjet;

    /**
     * @var string
     *
     * @ORM\Column(name="ydays_Perso_Pro_Projet", type="string", length=5, nullable=false)
     */
    private $ydaysPersoProProjet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_helper_Projet", type="integer", nullable=false)
     */
    private $idHelperProjet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_ChefProjet", type="integer", nullable=false)
     */
    private $idChefProjet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Evaluation", type="integer", nullable=false)
     */
    private $idEvaluation;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Projet", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProjet;

    /**
     * @var \AppBundle\Entity\Entreprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Entreprise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Entreprise", referencedColumnName="id_Entreprise")
     * })
     */
    private $idEntreprise;

    /**
     * @return string
     */
    public function getNomProjet()
    {
        return $this->nomProjet;
    }

    /**
     * @param string $nomProjet
     */
    public function setNomProjet($nomProjet)
    {
        $this->nomProjet = $nomProjet;
    }

    /**
     * @return string
     */
    public function getSalleProjet()
    {
        return $this->salleProjet;
    }

    /**
     * @param string $salleProjet
     */
    public function setSalleProjet($salleProjet)
    {
        $this->salleProjet = $salleProjet;
    }

    /**
     * @return string
     */
    public function getProjetExtIntProjet()
    {
        return $this->projetExtIntProjet;
    }

    /**
     * @param string $projetExtIntProjet
     */
    public function setProjetExtIntProjet($projetExtIntProjet)
    {
        $this->projetExtIntProjet = $projetExtIntProjet;
    }

    /**
     * @return string
     */
    public function getYdaysPersoProProjet()
    {
        return $this->ydaysPersoProProjet;
    }

    /**
     * @param string $ydaysPersoProProjet
     */
    public function setYdaysPersoProProjet($ydaysPersoProProjet)
    {
        $this->ydaysPersoProProjet = $ydaysPersoProProjet;
    }

    /**
     * @return int
     */
    public function getIdHelperProjet()
    {
        return $this->idHelperProjet;
    }

    /**
     * @param int $idHelperProjet
     */
    public function setIdHelperProjet($idHelperProjet)
    {
        $this->idHelperProjet = $idHelperProjet;
    }

    /**
     * @return int
     */
    public function getIdEvaluation()
    {
        return $this->idEvaluation;
    }

    /**
     * @param int $idEvaluation
     */
    public function setIdEvaluation($idEvaluation)
    {
        $this->idEvaluation = $idEvaluation;
    }

    /**
     * @return int
     */
    public function getIdProjet()
    {
        return $this->idProjet;
    }

    /**
     * @param int $idProjet
     */
    public function setIdProjet($idProjet)
    {
        $this->idProjet = $idProjet;
    }

    /**
     * @return Entreprise
     */
    public function getIdEntreprise()
    {
        return $this->idEntreprise;
    }

    /**
     * @param Entreprise $idEntreprise
     */
    public function setIdEntreprise($idEntreprise)
    {
        $this->idEntreprise = $idEntreprise;
    }

    /**
     * @return int
     */
    public function getIdChefProjet(): int
    {
        return $this->idChefProjet;
    }

    /**
     * @param int $idChefProjet
     */
    public function setIdChefProjet(int $idChefProjet): void
    {
        $this->idChefProjet = $idChefProjet;
    }


}

