<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="Entreprise")
 * @ORM\Entity
 */
class Entreprise
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_Entreprise", type="string", length=255, nullable=false)
     */
    private $nomEntreprise;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_Entreprise", type="integer", nullable=false)
     */
    private $numeroEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="voie_Entreprise", type="string", length=255, nullable=false)
     */
    private $voieEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_Entreprise", type="string", length=255, nullable=false)
     */
    private $villeEntreprise;

    /**
     * @var integer
     *
     * @ORM\Column(name="cp_Entreprise", type="integer", nullable=false)
     */
    private $cpEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_Entreprise", type="string", length=255, nullable=false)
     */
    private $paysEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="siret_Entreprise", type="string", length=255, nullable=false)
     */
    private $siretEntreprise;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Entreprise", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEntreprise;

    /**
     * @return string
     */
    public function getNomEntreprise()
    {
        return $this->nomEntreprise;
    }

    /**
     * @param string $nomEntreprise
     */
    public function setNomEntreprise($nomEntreprise)
    {
        $this->nomEntreprise = $nomEntreprise;
    }

    /**
     * @return int
     */
    public function getNumeroEntreprise()
    {
        return $this->numeroEntreprise;
    }

    /**
     * @param int $numeroEntreprise
     */
    public function setNumeroEntreprise($numeroEntreprise)
    {
        $this->numeroEntreprise = $numeroEntreprise;
    }

    /**
     * @return string
     */
    public function getVoieEntreprise()
    {
        return $this->voieEntreprise;
    }

    /**
     * @param string $voieEntreprise
     */
    public function setVoieEntreprise($voieEntreprise)
    {
        $this->voieEntreprise = $voieEntreprise;
    }

    /**
     * @return string
     */
    public function getVilleEntreprise()
    {
        return $this->villeEntreprise;
    }

    /**
     * @param string $villeEntreprise
     */
    public function setVilleEntreprise($villeEntreprise)
    {
        $this->villeEntreprise = $villeEntreprise;
    }

    /**
     * @return int
     */
    public function getCpEntreprise()
    {
        return $this->cpEntreprise;
    }

    /**
     * @param int $cpEntreprise
     */
    public function setCpEntreprise($cpEntreprise)
    {
        $this->cpEntreprise = $cpEntreprise;
    }

    /**
     * @return string
     */
    public function getPaysEntreprise()
    {
        return $this->paysEntreprise;
    }

    /**
     * @param string $paysEntreprise
     */
    public function setPaysEntreprise($paysEntreprise)
    {
        $this->paysEntreprise = $paysEntreprise;
    }

    /**
     * @return string
     */
    public function getSiretEntreprise()
    {
        return $this->siretEntreprise;
    }

    /**
     * @param string $siretEntreprise
     */
    public function setSiretEntreprise($siretEntreprise)
    {
        $this->siretEntreprise = $siretEntreprise;
    }

    /**
     * @return int
     */
    public function getIdEntreprise()
    {
        return $this->idEntreprise;
    }

    /**
     * @param int $idEntreprise
     */
    public function setIdEntreprise($idEntreprise)
    {
        $this->idEntreprise = $idEntreprise;
    }

    public function toString()
    {
        return $this->getNumeroEntreprise() . " " . $this->getVoieEntreprise(). ", " . $this->getCpEntreprise(). " " . $this->getVilleEntreprise();
    }
}

