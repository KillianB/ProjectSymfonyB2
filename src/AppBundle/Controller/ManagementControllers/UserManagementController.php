<?php
/**
 * Created by IntelliJ IDEA.
 * User: Malo
 * Date: 11/12/2017
 * Time: 15:14
 */

namespace AppBundle\Controller\ManagementControllers;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManagementController extends Controller
{

    /**
     * @Route("/managementUser/create", name="create_user")
     */
    public function createUser(LoggerInterface $logger,SessionInterface $session) {
        $RoleCurrentUser = $session->get('role');

        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('classe', ChoiceType::class, array(
                'choices' => array(
                    'Ingesup' => array(
                        'Bachelor 1' => 'IngeB1',
                        'Bachelor 2' => 'IngeB2',
                        'Bachelor 3' => 'IngeB3',
                        'Master 1' => 'IngeM1',
                        'Master 2' => 'IngeM2',
                    ),
                    'Lim\'art' => array(
                        'Bachelor 1' => 'LimartB1',
                        'Bachelor 2' => 'LimartB2',
                        'Bachelor 3' => 'LimartB3',
                        'Master 1' => 'LimartM1',
                        'Master 2' => 'LimartM2',
                    ),
                    'ESSCA/ISEE' => array(
                        'Bachelor 1' => 'IseeB1',
                        'Bachelor 2' => 'IseeB2',
                        'Bachelor 3' => 'IseeB3',
                        'Master 1' => 'Essca/IseeM1',
                        'Master 2' => 'Essca/IseeM2',
                    )
                ),
            ))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'SuperAdmin' => 'SuperAdmin',
                    'Admin' => 'Admin',
                    'Helper' => 'Helper',
                    'Chef de Projet' => 'Chef de Projet',
                    'Etudiant' => 'Etudiant',
                    'Etudiant non affecté' => 'Etudiant non affecté'
                ),
            ))
            ->add('mail', EmailType::class)
            ->add('tel', TextType::class)
            ->add('idSlack', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nomUser = $form->get('nom')->getData();
            $prenomUser = $form->get('prenom')->getData();
            $classeUser = $form->get('classe')->getData();
            $roleUser = $form->get('role')->getData();
            $mailUser = $form->get('mail')->getData();
            $telUser = $form->get('tel')->getData();
            $idSlackUser = $form->get('idSlack')->getData();
            $passwordUser = password_hash($form->get('password')->getData(), PASSWORD_BCRYPT);

            $user = new User();
            $user->setNomUser($nomUser);
            $user->setPrenomUser($prenomUser);
            $user->setClasseUser($classeUser);
            $user->setRoleUser($roleUser);
            $user->setMailUser($mailUser);
            $user->setTelUser($telUser);
            $user->setIdSlackUser($idSlackUser);
            $user->setPasswordUser($passwordUser);
            $user->setIsReset(1);

            $em->persist($user);

            $em->flush();

            $logger->info("Ajout de l'utilisateur ".$prenomUser." ".$nomUser." dans la base de données avec succès.");

            return $this->redirectToRoute('user_list');
        }
        return $this->render('CRUDManagement/cruduser.html.twig', array(
            'form' => $form->createView(),
            'roleCurrentUser' => $RoleCurrentUser
        ));
    }

    /**
     * @Route("/managementUser/delete/{id}", name="delete_user")
     */
    public function deleteUser($id, LoggerInterface $logger) {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->find($id);

        $em->remove($user);
        $em->flush();

        $logger->info("Utilisateur avec ID n°".$id." a été supprimé avec succès.");

        return $this->redirectToRoute('user_list');
    }

    /**
     * @Route("/managementUser/update/{id}", name="update_user")
     */
    public function updateUser($id, SessionInterface $session, LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);
        if ($session->get('role') == 'SuperAdmin') {
            $form = $this->createFormBuilder()
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('classe', ChoiceType::class, array(
                    'choices' => array(
                        'Ingesup' => array(
                            'Bachelor 1' => 'IngeB1',
                            'Bachelor 2' => 'IngeB2',
                            'Bachelor 3' => 'IngeB3',
                            'Master 1' => 'IngeM1',
                            'Master 2' => 'IngeM2',
                        ),
                        'Lim\'art' => array(
                            'Bachelor 1' => 'LimartB1',
                            'Bachelor 2' => 'LimartB2',
                            'Bachelor 3' => 'LimartB3',
                            'Master 1' => 'LimartM1',
                            'Master 2' => 'LimartM2',
                        ),
                        'ESSCA/ISEE' => array(
                            'Bachelor 1' => 'IseeB1',
                            'Bachelor 2' => 'IseeB2',
                            'Bachelor 3' => 'IseeB3',
                            'Master 1' => 'Essca/IseeM1',
                            'Master 2' => 'Essca/IseeM2',
                        )
                    ),
                ))
                ->add('role', ChoiceType::class, array(
                    'choices' => array(
                        'SuperAdmin' => 'SuperAdmin',
                        'Admin' => 'Admin',
                        'Helper' => 'Helper',
                        'Chef de Projet' => 'Chef de Projet',
                        'Etudiant' => 'Etudiant',
                        'Etudiant non affecté' => 'Etudiant non affecté'
                    ),
                ))
                ->add('mail', EmailType::class)
                ->add('tel', TextType::class)
                ->add('idSlack', TextType::class)
                ->getForm();
        }
        else{
            $form = $this->createFormBuilder()
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('mail', EmailType::class)
                ->add('tel', TextType::class)
                ->add('idSlack', TextType::class)
                ->getForm();
        }

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nomUser = $form->get('nom')->getData();
            $prenomUser = $form->get('prenom')->getData();
            if ($session->get('role') == 'SuperAdmin') {
                $classeUser = $form->get('classe')->getData();
                $roleUser = $form->get('role')->getData();
            }
            $mailUser = $form->get('mail')->getData();
            $telUser = $form->get('tel')->getData();
            $idSlackUser = $form->get('idSlack')->getData();

            $user->setNomUser($nomUser);
            $user->setPrenomUser($prenomUser);
            if ($session->get('role') == 'SuperAdmin') {
                $user->setClasseUser($classeUser);
                $user->setRoleUser($roleUser);
            }
            $user->setMailUser($mailUser);
            $user->setTelUser($telUser);
            $user->setIdSlackUser($idSlackUser);

            $em->flush();

            $logger->info("Modification de l'utilisateur ".$prenomUser." ".$nomUser." dans la base de données avec succès.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('CRUDManagement/cruduser.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }
}