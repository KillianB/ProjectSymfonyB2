<?php
/**
 * Created by IntelliJ IDEA.
 * User: Malo
 * Date: 11/12/2017
 * Time: 15:14
 */

namespace AppBundle\Controller\Project\ProjectManagement;

use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Projet;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;

class CommentProjectManagementController extends Controller
{

    /**
     * @Route("/managementCom/add/{idProjet}", name="create_com")
     */
    public function createCommentaire($idProjet, SessionInterface $session, LoggerInterface $logger) {

        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('contenu', TextareaType::class)
            ->add('date', TextType::class)
            ->add('priorite', ChoiceType::class, array(
                'choices' => array(
                    '1',
                    '2',
                    '3'
                ),
            ))
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contenu = $form->get('contenu')->getData();
            $date = $form->get('date')->getData();
            $priorite = $form->get('priorite')->getData();

            $comment = new Commentaire();
            $comment->setContenuCommentaire($contenu);
            $comment->setDateCommentaire(new \DateTime($date));
            $comment->setPrioriteCommentaire($priorite);
            $comment->setIdProjet($idProjet);
            $comment->setIdUser($session->get('user')->getIdUser());

            $em->persist($comment);

            $em->flush();

            $logger->info("Commentaire ajouté pour le projet d'ID n°".$idProjet." avec succès.");

            return $this->redirectToRoute('project_page', array(
                'idProjet' => $idProjet
            ));
        }
        return $this->render('project/projectManagement/crudProjetCommentaire.html.twig', array(
            'form' => $form->createView(),
            'idProjet' => $idProjet
        ));
    }

    /**
     * @Route("/managementCom/deleteCom/{id}/{idProjet}", name="delete_com")
     */
    public function deleteCommentaire($id, $idProjet, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository(Commentaire::class)->find($id);

        $em->remove($comment);
        $em->flush();

        $logger->info("Commentaire supprimé pour le projet d'ID n°".$idProjet." avec succès.");

        return $this->redirectToRoute('project_page', array(
            'idProjet' => $idProjet
        ));
    }

    /**
     * @Route("/managementCom/updateCom/{id}/{idProjet}", name="update_com")
     */
    public function updateCommentaire($id, $idProjet, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository(Commentaire::class)->find($id);

        $form = $this->createFormBuilder()
            ->add('contenu', TextareaType::class)
            ->add('date', TextType::class)
            ->add('priorite', ChoiceType::class, array(
                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3'
                ),
            ))
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contenu = $form->get('contenu')->getData();
            $date = $form->get('date')->getData();
            $priorite = $form->get('priorite')->getData();

            $commentaire->setContenuCommentaire($contenu);
            $commentaire->setDateCommentaire(new \DateTime($date));
            $commentaire->setPrioriteCommentaire($priorite);

            $em->flush();

            $logger->info("Commentaire modifié pour le projet d'ID n°".$idProjet." avec succès.");

            return $this->redirectToRoute('project_page', array(
                'idProjet' => $idProjet
            ));
        }
        return $this->render('project/projectManagement/crudProjetCommentaire.html.twig', array(
            'form' => $form->createView(),
            'idProjet' => $idProjet,
            'commentaire' => $commentaire
        ));
    }
}