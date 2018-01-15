<?php
/**
 * Created by IntelliJ IDEA.
 * User: Malo
 * Date: 12/12/2017
 * Time: 14:02
 */

namespace AppBundle\Controller\Project\ProjectManagement;

use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\CompteRendu;


class CompteRenduManagementController extends Controller
{
    /**
     * @Route("/managementCR/create/{idProjet}", name="create_cr")
     */
    public function createCompteRendu($idProjet, SessionInterface $session, LoggerInterface $logger) {

        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('titre', TextType::class)
            ->add('contenu', TextareaType::class)
            ->getForm();


        $form->handleRequest(Request::createFromGlobals());


        if ($form->isSubmitted() && $form->isValid()) {
            $compteRendu = new CompteRendu();
            $compteRendu->setTitreCompteRendu($form->get('titre')->getData());
            $compteRendu->setContenuCompteRendu($form->get('contenu')->getData());
            $compteRendu->setIdUser($session->get('id'));
            $compteRendu->setIdProjet($idProjet);

            $em->persist($compteRendu);

            $em->flush();

            $logger->info("Compte Rendu ".$compteRendu->getTitreCompteRendu()." ajouté avec succès.");

            return $this->redirectToRoute('project_page', array(
                'idProjet' => $idProjet
            ));
        }
        return $this->render('project/projectManagement/crudprojetcompterendu.html.twig', array(
            'form' => $form->createView(),
            'idProjet' => $idProjet
        ));

    }
    /**
     * @Route("/managementCR/delete/{id}/{idProjet}", name="delete_cr")
     */
    public function deleteCompteRendu($id, $idProjet, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $compteRendu = $em->getRepository(CompteRendu::class)->find($id);

        $em->remove($compteRendu);
        $em->flush();

        $logger->info("Compte Rendu ".$compteRendu->getTitreCompteRendu()." supprime avec succès.");

        return $this->redirectToRoute('project_page', array(
            'idProjet' => $idProjet
        ));
    }

    /**
     * @Route("/managementCR/update/{id}/{idProjet}", name="update_cr")
     */
    public function updateCompteRendu($id, $idProjet, SessionInterface $session, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $compteRendu = $em->getRepository(CompteRendu::class)->find($id);

        $form = $this->createFormBuilder()
            ->add('titre', TextType::class)
            ->add('contenu', TextareaType::class)
            ->getForm();


        $form->handleRequest(Request::createFromGlobals());


        if ($form->isSubmitted() && $form->isValid()) {
            $compteRendu->setTitreCompteRendu($form->get('titre')->getData());
            $compteRendu->setContenuCompteRendu($form->get('contenu')->getData());
            $compteRendu->setIdUser($session->get('id'));
            $compteRendu->setIdProjet($idProjet);

            $em->flush();

            $logger->info("Compte Rendu ".$compteRendu->getTitreCompteRendu()." modifie avec succès.");

            return $this->redirectToRoute('project_page', array(
                'idProjet' => $idProjet
            ));
        }
        return $this->render('project/projectManagement/crudprojetcompterendu.html.twig', array(
            'form' => $form->createView(),
            'idProjet' => $idProjet,
            'compteRendu' => $compteRendu
        ));
    }
}