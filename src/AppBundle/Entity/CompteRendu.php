<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompteRendu
 *
 * @ORM\Table(name="Compte_rendu", indexes={@ORM\Index(name="id_projet_idx", columns={"id_Projet"}), @ORM\Index(name="id_User_idx", columns={"id_User"})})
 * @ORM\Entity
 */
class CompteRendu
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre_Compte_rendu", type="string", length=255, nullable=true)
     */
    private $titreCompteRendu;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_Compte_rendu", type="string", length=500, nullable=true)
     */
    private $contenuCompteRendu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Compte_rendu", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCompteRendu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Projet", type="integer", length=11, nullable=false)
     */
    private $idProjet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_User", type="integer", length=11, nullable=false)
     */
    private $idUser;

    /**
     * @return string
     */
    public function getTitreCompteRendu(): string
    {
        return $this->titreCompteRendu;
    }

    /**
     * @param string $titreCompteRendu
     */
    public function setTitreCompteRendu(string $titreCompteRendu): void
    {
        $this->titreCompteRendu = $titreCompteRendu;
    }

    /**
     * @return string
     */
    public function getContenuCompteRendu(): string
    {
        return $this->contenuCompteRendu;
    }

    /**
     * @param string $contenuCompteRendu
     */
    public function setContenuCompteRendu(string $contenuCompteRendu): void
    {
        $this->contenuCompteRendu = $contenuCompteRendu;
    }

    /**
     * @return int
     */
    public function getIdCompteRendu(): int
    {
        return $this->idCompteRendu;
    }

    /**
     * @param int $idCompteRendu
     */
    public function setIdCompteRendu(int $idCompteRendu): void
    {
        $this->idCompteRendu = $idCompteRendu;
    }

    /**
     * @return int
     */
    public function getIdProjet(): int
    {
        return $this->idProjet;
    }

    /**
     * @param int $idProjet
     */
    public function setIdProjet(int $idProjet): void
    {
        $this->idProjet = $idProjet;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }


}

