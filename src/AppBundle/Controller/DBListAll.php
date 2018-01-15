<?php

// src/AppBundle/Controller/DBListAll.phppace AppBundle\Controller;

namespace AppBundle\Controller;
use AppBundle\Entity\Composer;
use AppBundle\Entity\Entreprise;
use AppBundle\Entity\EvaluationProjet;
use AppBundle\Entity\Projet;
use AppBundle\Entity\User;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DBListAll extends Controller
{
    /**
     * @Route("/listeUser", name="user_list")
     *
     */
    public function All_user(SessionInterface $session)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $session->set('lastPage', 'liste');

        return $this->render('View\listeUser.html.twig', array(
            'users' => $user,
        ));
    }




    /**
     * @Route("/listeProjet", name="project_list")
     */
    public function All_projet(SessionInterface $session, Connection $connection)
    {
        $id = $session->get('id');
        $projets = $connection->fetchAll("SELECT * FROM thbc_projetdev.Projet WHERE id_Evaluation <> 7");

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $eval = $this->getDoctrine()
            ->getRepository(EvaluationProjet::class)
            ->findAll();

        $Composer = $this->getDoctrine()
            ->getRepository(Composer::class)
            ->findBy(array("idUser" => $id));

        $tableau = [];
        foreach ($Composer as $comp){
            array_push($tableau,$comp -> getIdProjet());
        }

        return $this->render('View\listeProjet.html.twig', array(
            'users' => $user,
            'projets' => $projets,
            'eval' => $eval,
            'comp' => $tableau,
        ));

    }





    /**
     * @Route("/listeEntreprise", name="entreprise_list")
     */
    public function All_Entreprise()
    {
        $entreprise = $this->getDoctrine()
            ->getRepository(Entreprise::class)
            ->findAll();
        return $this->render('View\listeEntreprise.html.twig', array(
            'entreprises' => $entreprise,
        ));
    }
}