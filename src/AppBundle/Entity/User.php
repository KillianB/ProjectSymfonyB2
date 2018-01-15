<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="User")
 * @ORM\Entity
 */
class User
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_User", type="string", length=255, nullable=false)
     */
    private $nomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_User", type="string", length=255, nullable=false)
     */
    private $prenomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="classe_User", type="string", length=255, nullable=false)
     */
    private $classeUser;

    /**
     * @var string
     *
     * @ORM\Column(name="role_User", type="string", length=255, nullable=false)
     */
    private $roleUser;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_User", type="string", length=255, nullable=false)
     */
    private $mailUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel_User", type="integer", nullable=false)
     */
    private $telUser;

    /**
     * @var string
     *
     * @ORM\Column(name="id_slack_User", type="string", length=255, nullable=false)
     */
    private $idSlackUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_User", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="password_User", type="string", length=100, nullable=false)
     */
    private $passwordUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="isReset", type="integer", length=1, nullable=false)
     */
    private $isReset;

    /**
     * @return string
     */
    public function getNomUser()
    {
        return $this->nomUser;
    }

    /**
     * @param string $nomUser
     */
    public function setNomUser($nomUser)
    {
        $this->nomUser = $nomUser;
    }

    /**
     * @return string
     */
    public function getPrenomUser()
    {
        return $this->prenomUser;
    }

    /**
     * @param string $prenomUser
     */
    public function setPrenomUser($prenomUser)
    {
        $this->prenomUser = $prenomUser;
    }

    /**
     * @return string
     */
    public function getClasseUser()
    {
        return $this->classeUser;
    }

    /**
     * @param string $classeUser
     */
    public function setClasseUser($classeUser)
    {
        $this->classeUser = $classeUser;
    }

    /**
     * @return string
     */
    public function getRoleUser()
    {
        return $this->roleUser;
    }

    /**
     * @param string $roleUser
     */
    public function setRoleUser($roleUser)
    {
        $this->roleUser = $roleUser;
    }

    /**
     * @return string
     */
    public function getMailUser()
    {
        return $this->mailUser;
    }

    /**
     * @param string $mailUser
     */
    public function setMailUser($mailUser)
    {
        $this->mailUser = $mailUser;
    }

    /**
     * @return int
     */
    public function getTelUser()
    {
        return $this->telUser;
    }

    /**
     * @param int $telUser
     */
    public function setTelUser($telUser)
    {
        $this->telUser = $telUser;
    }

    /**
     * @return string
     */
    public function getIdSlackUser()
    {
        return $this->idSlackUser;
    }

    /**
     * @param string $idSlackUser
     */
    public function setIdSlackUser($idSlackUser)
    {
        $this->idSlackUser = $idSlackUser;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return string
     */
    public function getPasswordUser()
    {
        return $this->passwordUser;
    }

    /**
     * @param string $passwordUser
     */
    public function setPasswordUser($passwordUser)
    {
        $this->passwordUser = $passwordUser;
    }

    /**
     * @return int
     */
    public function getIsReset()
    {
        return $this->isReset;
    }

    /**
     * @param int $isReset
     */
    public function setIsReset($isReset)
    {
        $this->isReset = $isReset;
    }



    public function toString(){
        return $this->getNomUser() . " " . $this->getPrenomUser();
    }
}

