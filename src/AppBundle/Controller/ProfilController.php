<?php
/**
 * Created by IntelliJ IDEA.
 * User: maelb
 * Date: 09/12/2017
 * Time: 11:39
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Composer;
use AppBundle\Entity\Projet;
use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends Controller
{

    /**
     * @Route("/profil/{id}", name="profil_userName")
     */
    public function UserName($id, SessionInterface $session)
    {
        $idCurrentUser = $session->get('id');
        $RoleCurrentUser = $session->get('role');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for this id '.$id
            );
        }

        /* Récuperation dans la table composer du contenu pour le user selectionner */
        $Composer = $this->getDoctrine()
            ->getRepository(Composer::class)
            ->findBy(array("idUser" => $id));

        $tableau = [];
        /* pour les résultat récupérer dans composer création d'un tableau récupérant les id project */
        foreach ($Composer as $comp){
            array_push($tableau,$comp -> getIdProjet());
        }
        /* via les id project récupérer les infos du projet et mettre dans tableau tableauProject */
        $tableauProject = [];
        $tableauIdHelper = [];
        $tableauIdChefProjet = [];
        foreach ($tableau as $idProjet){
            $projet = $this->getDoctrine()
                ->getRepository(Projet::class)
                ->find($idProjet);
            array_push($tableauProject, $projet);
            array_push($tableauIdHelper, $projet->getIdHelperProjet());
            array_push($tableauIdChefProjet, $projet->getIdChefProjet());
        }
        $tableauNameChefProjet = [];
        foreach ($tableauIdChefProjet as $chefProjet){
            $chefProjetNom = $this ->getDoctrine()
                ->getRepository(User::class)
                ->find($chefProjet);
            array_push($tableauNameChefProjet,$chefProjetNom -> getPrenomUser());
        }
        $tableauNameHelper = [];
        foreach ($tableauIdHelper as $helper){
            $helperNom = $this ->getDoctrine()
                ->getRepository(User::class)
                ->find($helper);
            array_push($tableauNameHelper,$helperNom -> getPrenomUser());
        }
        $i=0;
        $userMail = $user->getMailUser();
        $userPhone = $user->getTelUser();
        $userSlack = $user->getIdSlackUser();
        $userRole = $user->getRoleUser();
        $userClasse = $user ->getClasseUser();
        $userName = $user->getNomUser();
        $userFirstName = $user->getPrenomUser();
        $session->set('lastPage', 'profil');
        return $this->render('profil.html.twig', array(
            'userName' => $userName,
            'userFirstName' => $userFirstName,
            'userClasse' => $userClasse,
            'userRole' =>$userRole,
            'userMail' =>$userMail,
            'userPhone' =>$userPhone,
            'userSlack' =>$userSlack,
            'projets' => $tableauProject,
            'currentUser' => $idCurrentUser,
            'roleCurrentUser' => $RoleCurrentUser,
            'idUser' => $id,
            'nomHelper' =>$tableauNameHelper,
            'i' => $i,
            'nomChefProjet' =>$tableauNameChefProjet
        ));
    }
    /**
     * @Route("/profil/mdp/{id}/")
     */
    public function newMdp($id, SessionInterface $session, LoggerInterface $logger){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)
            ->find($id);
        $form = $this -> createFormBuilder()
            ->add('password',PasswordType::class, array('label' => 'Nouveau mot de passe'))
            ->add('confirmer',PasswordType::class, array('label' =>'Confirmer le mot de passe'))
            ->getForm();
        $form->handleRequest(Request::createFromGlobals());
        if ($form ->isSubmitted() && $form->isValid() && $form -> get('password')->getData() == $form -> get('confirmer')->getData() ){
            $mdp = password_hash($form->get('password')->getData(), PASSWORD_BCRYPT);
            $user->setPasswordUser($mdp);

            if ($session->get('user')->getIdUser() != $id) {
                $user->setIsReset(1);
            } else {
                $user->setIsReset(0);
                $userSession = $em->getRepository(User::class)
                    ->find($id);
                $session->set('user', $userSession);
            }
            $em->flush();



            $logger->info("Modification du mot de passe de l'utilisateur ".$user->getPrenomUser()." ".$user->getNomUser().".");

            if ($session->get('lastPage') == 'liste') {
                return $this->redirectToRoute('user_list');
            } else {
                return $this->redirectToRoute('profil_userName', array('id' => $id));
            }
        }
        return $this->render('profil/newMdp.html.twig', array(
            'form' => $form->createView()
        ));
    }
}