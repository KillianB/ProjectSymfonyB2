<?php
/**
 * Created by IntelliJ IDEA.
 * User: Malo
 * Date: 11/12/2017
 * Time: 15:15
 */

namespace AppBundle\Controller\ManagementControllers;

use AppBundle\Entity\Entreprise;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\EvaluationProjet;
use AppBundle\Entity\Projet;

class ProjetManagementController extends Controller
{
    /**
     * @Route("/managementProjet/create", name="create_projet")
     */
    public function createProjet(LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();


        $helperArray = [];
        $evalArray = [];
        $entrepriseArray = [];

        $helpers = $this->getDoctrine()->getRepository(User::class)->findAll();

        foreach($helpers as $helper) {
            if($helper->getRoleUser() == "Helper") {
                $helperArray[$helper->getNomUser() . " " . $helper->getPrenomUser()] = $helper->getIdUser();
            }
        }

        $evaluations = $this->getDoctrine()->getRepository(EvaluationProjet::class)->findAll();

        foreach($evaluations as $eval) {
            $evalArray[$eval->getTypeEvaluation()] = $eval->getIdEvaluation();
        }

        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findAll();

        $entrepriseArray["Pas d'entreprise"] = null;
        foreach($entreprises as $entreprise) {
            $entrepriseArray[$entreprise->getNomEntreprise()] = $entreprise->getIdEntreprise();
        }

        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('salle', TextType::class)
            ->add('ext_int', ChoiceType::class, array(
                'choices' => array(
                    'Extérieur' => 'ext',
                    'Intérieur' => 'int',
                ),
            ))
            ->add('ydays_perso_pro', ChoiceType::class, array(
                'choices' => array(
                    'YDays Professionnel' => 'Pro',
                    'YDays Personnel' => 'Perso',
                ),
            ))
            ->add('helper', ChoiceType::class, array('choices' => $helperArray))
            ->add('evaluation', ChoiceType::class, array('choices' => $evalArray))
            ->add('entreprise', ChoiceType::class, array('choices' => $entrepriseArray))
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet = new Projet();
            $projet->setNomProjet($form->get('nom')->getData());
            $projet->setSalleProjet($form->get('salle')->getData());
            $projet->setProjetExtIntProjet($form->get('ext_int')->getData());
            $projet->setYdaysPersoProProjet($form->get('ydays_perso_pro')->getData());
            $projet->setIdHelperProjet($form->get('helper')->getData());
            $projet->setIdEvaluation($form->get('evaluation')->getData());
            $projet->setIdEntreprise($form->get('entreprise')->getData());

            $em->persist($projet);

            $em->flush();

            $logger->info("Ajout du projet ".$projet->getNomProjet()." dans la base de données avec succès.");

            return $this->redirectToRoute('project_list');
        }
        return $this->render('CRUDManagement/crudprojet.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/managementProjet/delete/{id}", name="delete_projet")
     */
    public function deleteProjet($id, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();

        $projet = $em->getRepository(Projet::class)->find($id);

        $projet->setIdEvaluation(7);
        $em->flush();
        $logger->info("Le projet ".$projet->getNomProjet()." a maintenant le statut supprimé. Succès de l'opération");

        return $this->redirectToRoute('project_list');
    }

    /**
     * @Route("/managementProjet/update/{id}", name="update_projet")
     */
    public function updateProjet($id, LoggerInterface $logger) {

        $em = $this->getDoctrine()->getManager();
        $projet = $em->getRepository(Projet::class)->find($id);

        $helperArray = [];
        $evalArray = [];
        $entrepriseArray = [];

        $helpers = $this->getDoctrine()->getRepository(User::class)->findAll();

        foreach($helpers as $helper) {
            if($helper->getRoleUser() == "Helper") {
                $helperArray[$helper->getNomUser() . " " . $helper->getPrenomUser()] = $helper->getIdUser();
            }
        }

        $evaluations = $this->getDoctrine()->getRepository(EvaluationProjet::class)->findAll();

        foreach($evaluations as $eval) {
            $evalArray[$eval->getTypeEvaluation()] = $eval->getIdEvaluation();
        }

        $entreprises = $this->getDoctrine()->getRepository(Entreprise::class)->findAll();

        $entrepriseArray["Pas d'entreprise"] = null;
        foreach($entreprises as $entreprise) {
            $entrepriseArray[$entreprise->getNomEntreprise()] = $entreprise->getIdEntreprise();
        }

        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('salle', TextType::class)
            ->add('ext_int', ChoiceType::class, array(
                'choices' => array(
                    'Extérieur' => 'ext',
                    'Intérieur' => 'int',
                ),
            ))
            ->add('ydays_perso_pro', ChoiceType::class, array(
                'choices' => array(
                    'YDays Professionnel' => 'Pro',
                    'YDays Personnel' => 'Perso',
                ),
            ))
            ->add('helper', ChoiceType::class, array('choices' => $helperArray))
            ->add('evaluation', ChoiceType::class, array('choices' => $evalArray))
            ->add('entreprise', ChoiceType::class, array('choices' => $entrepriseArray))
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setNomProjet($form->get('nom')->getData());
            $projet->setSalleProjet($form->get('salle')->getData());
            $projet->setProjetExtIntProjet($form->get('ext_int')->getData());
            $projet->setYdaysPersoProProjet($form->get('ydays_perso_pro')->getData());
            $projet->setIdHelperProjet($form->get('helper')->getData());
            $projet->setIdEvaluation($form->get('evaluation')->getData());
            $projet->setIdEntreprise($form->get('entreprise')->getData());

            $em->flush();

            $logger->info("Modification du projet ".$projet->getNomProjet()." dans la base de données avec succès.");


            return $this->redirectToRoute('project_list');
        }
        return $this->render('CRUDManagement/crudprojet.html.twig', array(
            'form' => $form->createView(),
            'projet' => $projet,
        ));
    }
}