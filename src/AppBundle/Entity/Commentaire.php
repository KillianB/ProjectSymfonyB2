<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="Commentaire", indexes={@ORM\Index(name="FK_Com_Projet_idx", columns={"id_Projet"}), @ORM\Index(name="FK_Com_User_idx", columns={"id_User"})})
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var string
     *
     * @ORM\Column(name="contenu_Commentaire", type="text", nullable=false)
     */
    private $contenuCommentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_Commentaire", type="date", nullable=false)
     */
    private $dateCommentaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="priorite_Commentaire", type="integer", nullable=false)
     */
    private $prioriteCommentaire;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Commentaire", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommentaire;

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
    public function getContenuCommentaire(): string
    {
        return $this->contenuCommentaire;
    }

    /**
     * @param string $contenuCommentaire
     */
    public function setContenuCommentaire(string $contenuCommentaire): void
    {
        $this->contenuCommentaire = $contenuCommentaire;
    }

    /**
     * @return \DateTime
     */
    public function getDateCommentaire(): \DateTime
    {
        return $this->dateCommentaire;
    }

    /**
     * @param \DateTime $dateCommentaire
     */
    public function setDateCommentaire(\DateTime $dateCommentaire): void
    {
        $this->dateCommentaire = $dateCommentaire;
    }

    /**
     * @return int
     */
    public function getPrioriteCommentaire(): int
    {
        return $this->prioriteCommentaire;
    }

    /**
     * @param int $prioriteCommentaire
     */
    public function setPrioriteCommentaire(int $prioriteCommentaire): void
    {
        $this->prioriteCommentaire = $prioriteCommentaire;
    }

    /**
     * @return int
     */
    public function getIdCommentaire(): int
    {
        return $this->idCommentaire;
    }

    /**
     * @param int $idCommentaire
     */
    public function setIdCommentaire(int $idCommentaire): void
    {
        $this->idCommentaire = $idCommentaire;
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

    /**
     * @return false|string
     */
    public function dateToString()
    {
        return date_format($this->getDateCommentaire(), "Y-m-d");
    }
}

