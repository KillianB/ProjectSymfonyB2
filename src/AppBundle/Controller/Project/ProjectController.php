<?php
/**
 * Created by IntelliJ IDEA.
 * User: Restauration
 * Date: 11/12/2017
 * Time: 11:51
 */

namespace AppBundle\Controller\Project;

use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Composer;
use AppBundle\Entity\CompteRendu;
use AppBundle\Entity\Entreprise;
use AppBundle\Entity\EvaluationProjet;
use AppBundle\Entity\Projet;
use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends Controller
{
    /**
     * @Route("/projet/{idProjet}", name="project_page", requirements={"idProjet"="\d+"})
     */
    public function displayProject($idProjet)
    {
        $projet = $this->getDoctrine()
            ->getRepository(Projet::class)
            ->find($idProjet);
        $helper = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(array('idUser' => $projet->getIdHelperProjet()));
        $evaluation = $this->getDoctrine()
            ->getRepository(EvaluationProjet::class)
            ->findOneBy(array('idEvaluation' => $projet->getIdEvaluation()));
        $memberID = $this->getDoctrine()
            ->getRepository(Composer::class)
            ->findBy(array('idProjet' => $idProjet));
        $commentaire = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findBy(array('idProjet' => $idProjet));
        $compterendu = $this->getDoctrine()
            ->getRepository(CompteRendu::class)
            ->findBy(array('idProjet' => $idProjet));
        $chefProjet = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($projet->getIdChefProjet());

        $members = array();
        $membersAll = array();
        foreach ($memberID as $value) {
            array_push($members, $test = $this->getDoctrine()
                                    ->getRepository(User::class)
                                    ->findOneBy(array('idUser' => $value->getIdUser())));
            array_push($membersAll, $test = $this->getDoctrine()
                                    ->getRepository(User::class)
                                    ->findOneBy(array('idUser' => $value->getIdUser()))
                                    ->getIdUser());
        }

        $allCommentaires = array();
        foreach ($commentaire as $value) {
            array_push($allCommentaires, array($value, $this->getDoctrine()
                ->getRepository(User::class)
                ->find($value->getIdUser())
                ->toString()));
        }

        $allCompterendu = array();
        foreach ($compterendu as $value) {
            array_push($allCompterendu, array($value, $this->getDoctrine()
                ->getRepository(User::class)
                ->find($value->getIdUser())
                ->toString()));
        }

        $entreprise = "";
        if ($projet->getProjetExtIntProjet() == "ext") {
            $entreprise = $this->getDoctrine()
                ->getRepository(Entreprise::class)
                ->find($projet->getIdEntreprise());
        }

        return $this->render('project/project.html.twig', array(
            'projet' => $projet,
            'helper' => $helper,
            'entreprise' => $entreprise,
            'evaluation' => $evaluation,
            'members' => $members,
            'commentaires' => $allCommentaires,
            'compterendus' => $allCompterendu,
            'memberID' => $membersAll,
            'chefProjet' => $chefProjet
        ));
    }

    /**
     * @Route("/projet/{idProjet}/addMember/{number}", name="project_addMember")
     */
     public function addMember($idProjet, $number) {
         $allUsers = $this->getDoctrine()
             ->getRepository(User::class)
             ->findAll();
         $composer = $this->getDoctrine()
             ->getRepository(Composer::class)
             ->findBy(array("idProjet" => $idProjet));

         $formBuilder = $this->createFormBuilder();
         for ($i = 1; $i < $number+1; $i++) {
             $formBuilder->add('number'.$i, TextType::class);
         }
         $form = $formBuilder->getForm();

         $request = Request::createFromGlobals();

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $data = $form->getData();
             if (count($data) !== count(array_unique($data))) {
                 return $this->render('project/addMembers.html.twig', array(
                     'form' => $form->createView(),
                     'number' => $number,
                     'idProjet' => $idProjet,
                     'users' => $allUsers,
                     'reason' => 'wrong'
                 ));
             }
             $em = $this->getDoctrine()->getManager();
             for ($i = 1; $i < $number+1; $i++) {
                 $fullName = explode(" ", $form->get('number'.$i)->getData());
                 $member = $this->getDoctrine()
                     ->getRepository(User::class)
                     ->findOneBy(array(
                         "nomUser" => $fullName[0],
                         "prenomUser" => $fullName[1]
                     ));
                 foreach ($composer as $value) {
                     if ($value->getIdUser() === $member->getIdUser()) {
                         return $this->render('project/addMembers.html.twig', array(
                             'form' => $form->createView(),
                             'number' => $number,
                             'idProjet' => $idProjet,
                             'users' => $allUsers,
                             'reason' => 'false'
                         ));
                     }
                }

                 $link = new Composer();
                 $link->setIdUser($member->getIdUser());
                 $link->setIdProjet($idProjet);
                 if ($member->getRoleUser() === "Etudiant non affecté") {
                     $member->setRoleUser("Etudiant");
                     $em->persist($member);
                 }
                 $em->persist($link);
                 $em->flush();
             }

             return $this->redirectToRoute('project_page', array(
                 'idProjet' => $idProjet
             ));
         }

         return $this->render('project/addMembers.html.twig', array(
             'form' => $form->createView(),
             'number' => $number,
             'idProjet' => $idProjet,
             'users' => $allUsers,
             'reason' => ''
         ));
     }

    /**
     * @Route("/projet/{idProjet}/deleteMember/{idMember}", name="project_deleteMember")
     */
     public function deleteMember($idMember, $idProjet, LoggerInterface $logger) {
         $em = $this->getDoctrine()->getManager();

         $toRemove = $em->getRepository(Composer::class)->findOneBy(array("idProjet" => $idProjet, "idUser" => $idMember));
         $em->remove($toRemove);
         $em->flush();

         $userInComposer = $em->getRepository(Composer::class)->findOneBy(array("idUser" => $idMember));
         if (empty($userInComposer)) {
             $user = $em->getRepository(User::class)->findOneBy(array("idUser" => $idMember));
             $user->setRoleUser("Etudiant non affecté");
             $em->flush();
         }

         $logger->info("Utilisateur avec ID n°".$idProjet." a été supprimé du projet avec succès.");

         return $this->redirectToRoute('project_page', array("idProjet" => $idProjet));
     }
}
