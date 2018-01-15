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

class EntrepriseManagementController extends Controller
{

    /**
     * @Route("/managementEntreprise/create", name="create_entreprise")
     */
    public function createEntreprise(LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('numero_rue', TextType::class)
            ->add('voie', TextType::class)
            ->add('ville', TextType::class)
            ->add('code_postal', TextType::class)
            ->add('pays', TextType::class)
            ->add('siret', TextType::class)
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nomEntreprise = $form->get('nom')->getData();
            $numeroRue = $form->get('numero_rue')->getData();
            $voie = $form->get('voie')->getData();
            $ville = $form->get('ville')->getData();
            $codePostal = $form->get('code_postal')->getData();
            $pays = $form->get('pays')->getData();
            $siret = $form->get('siret')->getData();

            $entreprise = new Entreprise();
            $entreprise->setNomEntreprise($nomEntreprise);
            $entreprise->setNumeroEntreprise($numeroRue);
            $entreprise->setVoieEntreprise($voie);
            $entreprise->setVilleEntreprise($ville);
            $entreprise->setCpEntreprise($codePostal);
            $entreprise->setPaysEntreprise($pays);
            $entreprise->setSiretEntreprise($siret);

            $em->persist($entreprise);

            $em->flush();

            $logger->info("Ajout de l'entreprise ".$nomEntreprise." dans la base de données avec succès.");

            return $this->redirectToRoute('entreprise_list');
        }
        return $this->render('CRUDManagement/crudentreprise.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/managementEntreprise/delete/{id}", name="delete_entreprise")
     */
    public function deleteEntreprise($id, LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();

        $entreprise = $em->getRepository(Entreprise::class)->find($id);

        $em->remove($entreprise);
        $em->flush();

        $logger->info("Entreprise avec ID n°".$id." a été supprimée avec succès.");

        return $this->redirectToRoute('entreprise_list');
    }

    /**
     * @Route("/managementEntreprise/update/{id}", name="update_entreprise")
     */
    public function updateEntreprise($id, LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();
        $entreprise = $em->getRepository(Entreprise::class)->find($id);

        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('numero_rue', TextType::class)
            ->add('voie', TextType::class)
            ->add('ville', TextType::class)
            ->add('code_postal', TextType::class)
            ->add('pays', TextType::class)
            ->add('siret', TextType::class)
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nomEntreprise = $form->get('nom')->getData();
            $numeroRue = $form->get('numero_rue')->getData();
            $voie = $form->get('voie')->getData();
            $ville = $form->get('ville')->getData();
            $codePostal = $form->get('code_postal')->getData();
            $pays = $form->get('pays')->getData();
            $siret = $form->get('siret')->getData();

            $entreprise->setNomEntreprise($nomEntreprise);
            $entreprise->setNumeroEntreprise($numeroRue);
            $entreprise->setVoieEntreprise($voie);
            $entreprise->setVilleEntreprise($ville);
            $entreprise->setCpEntreprise($codePostal);
            $entreprise->setPaysEntreprise($pays);
            $entreprise->setSiretEntreprise($siret);

            $em->flush();
            $logger->info("Modification de l'entreprise ".$nomEntreprise." dans la base de données avec succès.");

            return $this->redirectToRoute('entreprise_list');
        }

        return $this->render('CRUDManagement/crudentreprise.html.twig', array(
            'form' => $form->createView(),
            'entreprise' => $entreprise,
        ));
    }
}