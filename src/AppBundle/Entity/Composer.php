<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Composer
 *
 * @ORM\Table(name="Composer", uniqueConstraints={@ORM\UniqueConstraint(name="id_Projet_UNIQUE", columns={"id_Projet"}), @ORM\UniqueConstraint(name="id_User_UNIQUE", columns={"id_User"})})
 * @ORM\Entity
 */
class Composer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_Composer", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComposer;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Projet", type="integer")
     */
    private $idProjet;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_User", type="integer")
     */
    private $idUser;

    /**
     * @return int
     */
    public function getIdComposer()
    {
        return $this->idComposer;
    }

    /**
     * @param int $idComposer
     */
    public function setIdComposer(int $idComposer)
    {
        $this->idComposer = $idComposer;
    }

    /**
     * @return integer
     */
    public function getIdProjet()
    {
        return $this->idProjet;
    }

    /**
     * @param integer $idProjet
     */
    public function setIdProjet(int $idProjet)
    {
        $this->idProjet = $idProjet;
    }

    /**
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param integer $idUser
     */
    public function setIdUser(int $idUser)
    {
        $this->idUser = $idUser;
    }


}

