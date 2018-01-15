<?php
/**
 * Created by IntelliJ IDEA.
 * User: Restauration
 * Date: 09/12/2017
 * Time: 09:40
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    /**
     * @Route("/", name="app_connexion")
     */
    public function connect(SessionInterface $session, LoggerInterface $logger)
    {
        $session->remove('id');
        $session->remove('user');
        $session->remove('role');
        $form = $this->createFormBuilder()
            ->add('Email', TextType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $request = Request::createFromGlobals();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailForm = $form->get('Email')->getData();
            $password = $form->get('password')->getData();

            $mailDB = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(array("mailUser" => $mailForm));

            if (sizeof($mailDB) > 0) {
                $passwordDB = $mailDB->getPasswordUser();
            }

            if ($mailDB && password_verify($password, $passwordDB)) {
                $session->set('role', $mailDB->getRoleUser());
                $session->set('id', $mailDB->getIdUser());
                $session->set('user', $mailDB);

                $logger->info("Connexion etablie du compte ".$mailForm);

                return $this->redirectToRoute('app_homepage');
            } else {
                $logger->info("Connexion echouée du compte ".$mailForm." !");

                return $this->render('login/login.html.twig', array(
                    'form' => $form->createView(),
                    'reason' => 'wrong'
                ));
            }
        }
        return $this->render('login/login.html.twig', array(
            'form' => $form->createView(),
            'reason' => ''
        ));
    }

    /**
     * @Route("/homepage", name="app_homepage")
     */
    public function pageALogin() {
        return $this->render('homepage/homepage.html.twig');
    }
}