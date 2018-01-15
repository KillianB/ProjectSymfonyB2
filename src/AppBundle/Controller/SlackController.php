<?php 
namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\User;

class SlackController extends Controller 
{
    /**
     * @Route("/slack", name="Slack")
     */
    public function slack()
    {
		$users = $this->getDoctrine()->getRepository(User::class)->findAll();

		return $this->render('messages/messages.html.twig', array('users' => $users));
    }

    /**
     * @Route("/slack/send", name="slack_form")
     */    	
    public function slackForm()
    {
    	$form = $this->createFormBuilder()
            ->add('message', TextType::class)
            ->getForm();

        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->get('message')->getData();
            if (!empty($message)) {
                return $this->redirectToRoute('slack_send', array(
                    'message' => $message
                ));
            } else {
                return $this->render('messages/messages.html.twig', array(
                    'form' => $form->createView(),
                    'reason' => 'wrong'
                ));
            }
        }
        return $this->render('messages/messages.html.twig', array(
            'form' => $form->createView(),
            'reason' => 'mdr'
        ));
    }

    /**
     * @Route("/slack/message/{message}", name="slack_send")
     */    	
    /*public function slackSend($message)
    {
	    $this->container->get('part_fire_slack_service')->sendMessage(
	        $message,
	        'general',
	        ':100:'
	    	);


        return $this->render('messages/messages.html.twig');
    }*/

	/**
	 * @Route("/slack/mdr/{$userSlackId}", name="SendMessage")
	 */
	public function sendMessage($userSlackId) {

		return $this->render('messages/messages.html.twig');
	}

}
