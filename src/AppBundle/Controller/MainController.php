<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\User;

class MainController extends Controller
{

    /**
     * @Route("/main", name="Main")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('main/main.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/main/showUsers", name="addUser")
     */
    public function listUsers() {

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('messages/messages.html.twig', array('users' => $users));
    }

    /**
     * @Route("/main/{id}", name="UserID")
     */
    public function showEtudiant($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

            if(!$user) {
                throw $this->createNotFoundException(
                    "Pas d'utilisateur ? wtf");
            }

        return new Response("C'est cet utilisateur ! Il correspond à l'id ".$user->getIdUser().", et il s'appelle ".$user->getPrenomUser()." ".$user->getNomUser().".");
    }



}
